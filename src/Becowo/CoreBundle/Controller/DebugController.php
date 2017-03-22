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

 //    $converter = $this->get('css_to_inline_email_converter');
 //    $converter->setCSS('');
 //    $converter->setHTMLByView('CommonViews/Mail/Footer-contact.html.twig',
 //                array(
 //                  'name' => 'prenom',
 //                  'email' => 'prenom@test.com',
 //                  'subject' => 'test debug',
 //                  'message' => 'message'
 //                ));
 //    $body = $converter->generateStyledHTML();

                             
	// $curl = curl_init();

	// $url = $this->container->getParameter('mailgun.urlApiSendMessage');
	// $from = urlencode($this->container->getParameter('mailgun.from'));
	// $to = urlencode("odecharette@gmail.com"); //You can use commas to separate multiple recipients.
	// $bcc = urlencode($this->container->getParameter('mailgun.bcc'));
	// $subject = urlencode("test mailgun");
	// $params = "from=" . $from . "&to=" . $to . "&subject=" . $subject . "&bcc=" . $bcc;
	// $postfields = array(
	//     'html' => $body,
	//     'o:tag' => $this->get('kernel')->getEnvironment(),
	//     'o:tag' => 'Footer contact'
	// );

	// curl_setopt($curl,CURLOPT_URL,$url . $params); 
	// curl_setopt($curl,CURLOPT_USERPWD,
	// 	$this->container->getParameter('mailgun.username') . ":" . $this->container->getParameter('mailgun.password'));
	// curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);
	// curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
	// curl_setopt($curl,CURLOPT_POSTFIELDS,$postfields);
	// curl_setopt($curl,CURLOPT_URL,$url . $params);

	// $response = curl_exec($curl);
	// $err = curl_error($curl);

	// curl_close($curl);

	// if ($err) {
	//   echo "cURL Error #:" . $err;
	// } else {
	//   echo $response;
	// }


  	$emailService = $this->get('app.email');
  	$emailTemplate = "Footer-contact";
  	$emailParams = array('name' => 'prenom',
                  'email' => 'prenom@test.com',
                  'subject' => 'test debug',
                  'message' => 'message');
  	$emailTag = "Footer contact";
  	$to = "odecharette@gmail.com";
  	$subject = "test app.email";

  	$content = $emailService->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);

    return $this->render('Debug/view.html.twig', array('content' => $content, 'contentToDump' => $contentToDump));

  }


}
