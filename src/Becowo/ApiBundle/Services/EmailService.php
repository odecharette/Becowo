<?php

namespace Becowo\ApiBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

class EmailService
{
    private $inlineConverter = null;
    private $container = null;
    private $logger = null;

    public function __construct($inlineConverter, Container $container, $logger)
    {
        $this->inlineConverter = $inlineConverter;
        $this->container = $container;
        $this->logger = $logger;
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
		    'o:tag' => $emailTag //A single message may be marked with up to 3 tags.
		);
		

		curl_setopt($curl,CURLOPT_URL,$url . $params); 
		curl_setopt($curl,CURLOPT_USERPWD,
			$this->container->getParameter('mailgun.username') . ":" . $this->container->getParameter('mailgun.password'));
		curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
		curl_setopt($curl,CURLOPT_POSTFIELDS,$postfields);
		curl_setopt($curl,CURLOPT_URL,$url . $params);

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
}
