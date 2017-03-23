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

    // Permet de tester l'envoi d'un email avec mailgun : 
  	$emailService = $this->get('app.email');
  	$emailTemplate = "Footer-contact";
  	$emailParams = array('name' => 'prenom',
                  'email' => 'prenom@test.com',
                  'subject' => 'test debug',
                  'message' => 'message');
  	$emailTag = "test debug 2";
  	$to = "odecharette@gmail.com";
  	$subject = "test app.email";

  	$content = $emailService->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);

    return $this->render('Debug/view.html.twig', array('content' => $content, 'contentToDump' => $contentToDump));

  }


}
