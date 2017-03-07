<?php

namespace Becowo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends Controller
{

  public function createFacebookPageEventsAction(Request $request)
  {
    $ApiService = $this->get('app.api');

    $eventsParam = $ApiService->getApiEventsParam();

    // On va chercher les FB events de tous les WS renseignés dans la table ApiEvents, depuis la dernière update date
    foreach ($eventsParam as $param) {
        
        $events = $ApiService->getFacebookPageEvents($param->getFacebookPageId());
        
        if($events != null)
        {
            $ApiService->saveFacebookPageEvents($events, $param->getFacebookPageId(), $param->getWorkspace());
        }
    }

	return $this->render('Api/events.html.twig',array('events' => $events));
  }


  

}