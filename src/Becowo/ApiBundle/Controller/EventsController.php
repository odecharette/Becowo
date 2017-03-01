<?php

namespace Becowo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends Controller
{

  public function createFacebookPageEventsAction(Request $request)
  {
    $ApiService = $this->get('app.api');

    $events = $ApiService->getFacebookPageEvents('221146468037685'); // ID de la page Facebook wereso lille

    if(is_array($events))
    {
        // TO DO : log number events created
        $ApiService->saveFacebookPageEvents($events);

    }else{
        // TO DO : log error
    }

	return $this->render('Api/events.html.twig',array('events' => $events));
  }


  

}
