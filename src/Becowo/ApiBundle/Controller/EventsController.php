<?php

namespace Becowo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventsController extends Controller
{
  public function getFacebookPageEventsAction()
  {

	$FB_API_GRAPH_URL = 'https://graph.facebook.com';
    $FB_API_ID = $this->getParameter('facebook_client_id');
    $FB_API_SECRET = $this->getParameter('facebook_client_secret');
    $FB_PAGE_ID = '221146468037685'; // ID de la page Facebook wereso lille

    // Construction de l'URL à appeler pour récupérer une APP access_token
    $url = $FB_API_GRAPH_URL.'/oauth/access_token?client_id='.$FB_API_ID.'&client_secret='.$FB_API_SECRET.'&grant_type=client_credentials';
    // Appel à l'API
    $response = \Httpful\Request::get($url)->parseWith(function($body) {
        $access_token = str_replace("access_token=", "", $body); 
        // on parse au préalable le résultat récupéré qui est sous la forme "access_token=<access_token>"
        return $access_token;
    })->send();


    // Si on récupère quelque chose
    if (isset($response->body) && !empty($response->body)) {
        
        $access_token =$response->body;
        
        if (!empty($access_token)) {
            // Construction de l'URL à appeler pour récupérer les évènements de la page
            $url = $FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/events?access_token='.$access_token.'&format=json';
            // Appel à l'API
            $response = \Httpful\Request::get($url)->send();
            // si data existe, c'est un array() qui contient tous les évènements relatifs à cette page
            if (isset($response->body->data)) {
                // affichage des données récupérées
                $events = $response->body->data;
                // Traitement des données
                foreach($response->body->data as $event) {
                    // traitement et affichage des données
                }
            }
        }
        else {
            $events = "No token";
        }
    }
    else {
        $events = "Bad access token";
    }
    return $this->render('Api/events.html.twig',array('events' => $events));
  }


  

}
