<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Httpful\Mime;

class DebugController extends Controller
{

  public function viewAction()
  {
    $contentToDump = "";
    $content = "";

    // DOC API : https://documentation.mailgun.com/api-sending.html#sending
    // Pour générer le code cUrl, je testé l'API dans Postman, clique sur bouton 'code' + choix PHP cURL

    $converter = $this->get('css_to_inline_email_converter');
    $converter->setCSS('');
    $converter->setHTMLByView('CommonViews/Mail/Footer-contact.html.twig',
                array(
                  'name' => 'prenom',
                  'email' => 'prenom@test.com',
                  'subject' => 'test debug',
                  'message' => 'message'
                ));
    $body = $converter->generateStyledHTML();

                             
	$curl = curl_init();

	$url = "https://api.mailgun.net/v3/mailgun.becowo.com/messages?";
	$params = "from=Contact%20Becowo<contact%40becowo.com>&to=odecharette%40gmail.com&subject=Test%20curl3";
	$postfields = array(
	    'html' => $body,
	    'o:tag' => $this->get('kernel')->getEnvironment(),
	    'o:tag' => 'Footer contact'
	);
	//A single message may be marked with up to 3 tags.

	curl_setopt($curl,CURLOPT_URL,$url . $params); 
	curl_setopt($curl,CURLOPT_USERPWD,"api:key-47a9d9c74b4b7603b9c13e27f3dda892");
	curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
	curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
	curl_setopt($curl,CURLOPT_POSTFIELDS,$postfields);
	curl_setopt($curl,CURLOPT_URL,$url . $params);


	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}

    return $this->render('Debug/view.html.twig', array('content' => $content, 'contentToDump' => $contentToDump));

  }


}
