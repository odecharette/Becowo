<?php

namespace Becowo\ApiBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Becowo\ApiBundle\Entity\EmailEvents;

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
		// curl_setopt($curl,CURLOPT_URL,$url . $params);

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

    	$this->logger->notice('getEmailEvents : Start');

	    $curl = curl_init();

		$url = $this->container->getParameter('mailgun.urlApigetEvents');

		$yesterdayMorning = strtotime("yesterday 00:00:01");
		$yesterdayEvening = strtotime("yesterday 23:59:59");
		$params = "begin=" . $yesterdayMorning . "&end=" . $yesterdayEvening;

		$this->logger->notice('getEmailEvents : begin= ' . $yesterdayMorning . ' end= ' . $yesterdayEvening);

		if($nextPage == null)
		{
			curl_setopt($curl,CURLOPT_URL,$url . "?" . $params); 
		}else
		{
			curl_setopt($curl,CURLOPT_URL,$nextPage);
		}
		
		curl_setopt($curl,CURLOPT_USERPWD,
			$this->container->getParameter('mailgun.username') . ":" . $this->container->getParameter('mailgun.password'));
		curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"GET");
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true); // CURLOPT_RETURNTRANSFER tells PHP to store the response in a variable instead of printing it to the page, so $response will contain your response

		$response = curl_exec($curl);

		if($response){
			$this->logger->notice('getEmailEvents : Response OK : ');
		}else{
			$this->logger->error('getEmailEvents : Response failed : ' . $response);
		}

		$err = curl_error($curl);
		if ($err) {
			$this->logger->error('getEmailEvents FAILED : ' . $err);
		}

		curl_close($curl);
		$this->logger->notice('getEmailEvents : End');

		// Save emailEvents in db then go on the next page
		/************ paging not working, ticket sent to mailgun ******/
		$this->saveEmailEventsInDb($response);

		// $paging = json_decode($response)->paging;
		// dump($paging);
		// $i = 1;
		// if($paging->next != null)
		// {
		// 	echo '*************************************go next ' . $paging->next . "\n";
		// 	$i++;
		// 	$this->getEmailEvents($paging->next);
		// }
		// if($paging->next != $paging->last)
		// {
		// 	return $paging->next;
		// }else
		// {
		// 	return null;
		// }
		return '';

    }

    public function saveEmailEventsInDb($data)
    {
    	// $data est le JSON renvoyé par getEmailEvents() via l'API de mailgun

    	$this->logger->notice('saveEmailEventsInDb - Start');

		$json_data = json_decode($data);
		$items = $json_data->items;
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
				$this->em->persist($event);
			}
		}

		$this->em->flush();
		$this->logger->notice('saveEmailEventsInDb - ' . count($items) . " items found \n");
		echo "************ " . count($items) . " items found \n";

    	return "";
    }
}
