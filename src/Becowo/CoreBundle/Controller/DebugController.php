<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DebugController extends Controller
{

  public function viewAction()
  {
    $contentToDump = "";
    $content = "";

    $contentToDump = $this->get('mailer')->getTransport();

    return $this->render('Debug/view.html.twig', array('content' => $content, 'contentToDump' => $contentToDump));

  }


}
