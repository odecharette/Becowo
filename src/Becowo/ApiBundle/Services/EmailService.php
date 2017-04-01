<?php

namespace Becowo\ApiBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Becowo\ApiBundle\Entity\EmailEvents;
use Becowo\ApiBundle\Entity\EmailStats;

class EmailService
{
    private $inlineConverter = null;
    private $container = null;
    private $logger = null;
    private $em = null;

    public function __construct($inlineConverter, Container $container, $logger, EntityManager $em)
    {
        $this->inlineConverter = $inlineConverter;
        $this->container = $container;
        $this->logger = $logger;
        $this->em = $em;
    }

    public function sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject)
    {
    	// DOC API : https://documentation.mailgun.com/api-sending.html#sending
    	// Pour générer le code cUrl, je testé l'API dans Postman, clique sur bouton 'code' + choix PHP cURL

    	$id = uniqid();
    	$this->logger->notice($id . ' - sendEmail : ' . $emailTag . ' to ' . $to);

    	$this->inlineConverter->setCSS('');
	    $this->inlineConverter->setHTMLByView('CommonViews/Mail/' . $emailTemplate . ".html.twig",$emailParams);
	    $body = $this->inlineConverter->generateStyledHTML();

	    $curl = curl_init();

		$url = $this->container->getParameter('mailgun.urlApiSendMessage');
		$from = urlencode($this->container->getParameter('mailgun.from'));
		$to = urlencode($to); //You can use commas to separate multiple recipients.
		$bcc = urlencode($this->container->getParameter('mailgun.bcc'));
		$subject = urlencode($subject);
		$params = "from=" . $from . "&to=" . $to . "&subject=" . $subject . "&bcc=" . $bcc;

		$postfields = array(
		    'html' => $body,
	    	'o:tag' => $this->container->get('kernel')->getEnvironment() . ',' . $emailTag
		);

		curl_setopt($curl,CURLOPT_URL,$url . $params); 
		curl_setopt($curl,CURLOPT_USERPWD,
			$this->container->getParameter('mailgun.username') . ":" . $this->container->getParameter('mailgun.password'));
		curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($curl,CURLOPT_POSTFIELDS,$postfields);
		curl_setopt($curl,CURLOPT_CAINFO, $this->container->getParameter('cacert'));

		$response = curl_exec($curl);
		if($response){
			$this->logger->notice($id . ' - response : OK');
		}else{
			$this->logger->error($id . ' - response : ' . $response);
		}

		$err = curl_error($curl);
		if ($err) {
			$this->logger->error($id . ' - erreurs : ' . $err);
		}

		curl_close($curl);
		$this->logger->notice($id . ' - end');

		return $response;
    }

    public function getEmailEvents($nextPage = null)
    {
    	// Récupère les logs liés aux emails, générés par Mailgun
    	// Ils ne sont gardés que 2 jours chez Mailgun avec un compte gratuit, donc on les récupère dans la BDD de Becowo
    	// Ce service est appelé via un cron job
    	// Doc API : https://documentation.mailgun.com/api-events.html
    	// Good to know : j'ai du indiquer l'emplacement du fichier cacert.pem dans les fichier php.ini (WEB, PHP 5, PHP 7)
    	// curl.cainfo="C:/wamp64/cacert.pem"
    	// Finallement j'utilise le fichier cacert.pem en local (copié ds dossier web) sinon ca ne marche pas sur le serveur
    	// To traverse the entire range, you should keep requesting the next page URLs returned until an empty result page is reached.

		$curl = curl_init();

		if($nextPage == null)
		{
    		$this->logger->notice('getEmailEvents : Start');
			
			$url = $this->container->getParameter('mailgun.urlApigetEvents');
			$yesterdayMorning = strtotime("yesterday 00:00:01");
			// $params = "begin=" . $yesterdayMorning . "&limit=100&ascending=no";
			$params = "limit=100";

			$this->logger->notice('getEmailEvents : limit=100 ');

			curl_setopt($curl,CURLOPT_URL,$url . "?" . $params); 
		}else
		{
    		$this->logger->notice('getEmailEvents : read nextPage');
			curl_setopt($curl,CURLOPT_URL,$nextPage);
		}
		
		curl_setopt($curl,CURLOPT_USERPWD,
			$this->container->getParameter('mailgun.username') . ":" . $this->container->getParameter('mailgun.password'));
		curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"GET");
		curl_setopt($curl,CURLOPT_CAINFO, $this->container->getParameter('cacert'));
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true); // CURLOPT_RETURNTRANSFER tells PHP to store the response in a variable instead of printing it to the page, so $response will contain your response

		$response = curl_exec($curl);

		if($response){
			$this->logger->notice('getEmailEvents : Response OK');

			$responseJson = json_decode($response);
			$nbItems = count($responseJson->items);

			// Save emailEvents in db then go on the next page
			$this->saveEmailEventsInDb($responseJson);

			$this->logger->notice('getEmailEvents : ' . $nbItems . ' found');

			if($nbItems > 0)
			{
				return $responseJson->paging->next;
			}else
			{
				curl_close($curl);
				$this->logger->notice('getEmailEvents : End');
				return null;
			}
		}


		$err = curl_error($curl);
		if ($err) {
			$this->logger->error('getEmailEvents FAILED : ' . $err);
		}

		curl_close($curl);
		$this->logger->notice('getEmailEvents : End');

		return null;
    }

    public function saveEmailEventsInDb($responseJson)
    {
    	$this->logger->notice('saveEmailEventsInDb - Start');

		$items = $responseJson->items;
		$j=0;
		foreach ($items as $item) {

			$repo = $this->em->getRepository('BecowoApiBundle:EmailEvents');
   			$existingID = $repo->findBy(array('eventId' => $item->id));

			if(!$existingID)
			{
				$tags = "";
				foreach ($item->tags as $tag) {
					$tags = $tags . $tag . ",";
				}

				$subject = "";
				if(isset($item->message->headers->subject))
					$subject = $item->message->headers->subject;

				$d = new \DateTime();
				$d->setTimestamp($item->timestamp);

				$event = new EmailEvents();
				$event->setEventId($item->id);
				$event->setEmailId(explode('@', get_object_vars($item->message->headers)['message-id'])[0]);
				$event->setTags($tags);
				$event->setDateSent($d);
				$event->setRecipient($item->recipient);
				$event->setSubject($subject);
				$event->setEvent($item->event);
				if($item->event == "clicked")
				{
					$event->setUrlClicked($item->url);
				}
				$this->em->persist($event);
				$j++;
			}
		}

		$this->em->flush();
		$this->logger->notice('saveEmailEventsInDb - ' . count($items) . " items found \n");
		$this->logger->notice('saveEmailEventsInDb - ' . $j . " items saved in DB \n");
		echo "************ " . count($items) . " items found \n";

    	return "";
    }

    public function getEmailStats()
    {
		$curl = curl_init();

		$this->logger->notice('getEmailStats : Start');
		
		$url = $this->container->getParameter('mailgun.urlApigetStats');
		$params = "duration=2m&event=accepted&event=delivered&event=failed&event=opened&event=clicked&event=unsubscribed&event=complained&event=stored";

		$this->logger->notice('getEmailStats : duration=2m&event=accepted&event=delivered&event=failed&event=opened&event=clicked&event=unsubscribed&event=complained&event=stored ');

		curl_setopt($curl,CURLOPT_URL,$url . $params); 
		
		curl_setopt($curl,CURLOPT_USERPWD,
			$this->container->getParameter('mailgun.username') . ":" . $this->container->getParameter('mailgun.password'));
		curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"GET");
		curl_setopt($curl,CURLOPT_CAINFO, $this->container->getParameter('cacert'));
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true); // CURLOPT_RETURNTRANSFER tells PHP to store the response in a variable instead of printing it to the page, so $response will contain your response

		$response = curl_exec($curl);

		if($response){
			$this->logger->notice('getEmailStats : Response OK');

			$responseJson = json_decode($response);

			// Save emailStats in db
			$this->saveEmailStatsInDb($responseJson);
		}

		$err = curl_error($curl);
		if ($err) {
			$this->logger->error('getEmailStats FAILED : ' . $err);
		}

		curl_close($curl);
		$this->logger->notice('getEmailStats : End');

		return null;
    }

    public function saveEmailStatsInDb($responseJson)
    {
    	$this->logger->notice('saveEmailStatsInDb - Start');

		$items = $responseJson->stats;
		foreach ($items as $item) {

			$repo = $this->em->getRepository('BecowoApiBundle:EmailStats');

   			$existingID = $repo->findOneBy(array('statTime' => $item->time));

			if(!$existingID)
			{
				$stat = new EmailStats();
				$stat->setStatTime($item->time);
			}else{
				$stat = $existingID;
			}

			$stat->setAcceptedIncoming($item->accepted->incoming);
			$stat->setAcceptedOutgoing($item->accepted->outgoing);
			$stat->setDelivered($item->delivered->total);
			if(isset($item->failed->temporary->espblock)){
				$stat->setFailedTempEsp($item->failed->temporary->espblock);
			}
			if(isset($item->failed->permanent->espblock))
			{
				$stat->setFailedPermanentSuppressBounce(get_object_vars($item->failed->permanent->espblock)['suppress-bounce']);
				$stat->setFailedPermanentSuppressUnsubscribe(get_object_vars($item->failed->permanent->espblock)['suppress-unsubscribe']);
				$stat->setFailedPermanentSuppressComplaint(get_object_vars($item->failed->permanent->espblock)['suppress-complaint']);
			}
			
			$stat->setFailedPermanentBounce($item->failed->permanent->bounce);
			$stat->setFailedPermanentTotal($item->failed->permanent->total);
			$stat->setNbStored($item->stored->total);
			$stat->setOpened($item->opened->total);
			$stat->setClicked($item->clicked->total);
			if(isset($item->unsuscribed->total))
				$stat->setUnsuscribed($item->unsuscribed->total);
			$stat->setComplained($item->complained->total);

			$this->em->persist($stat);
		}

		$this->em->flush();
		$this->logger->notice('saveEmailStatsInDb - End');

    	return "";
    }
}
