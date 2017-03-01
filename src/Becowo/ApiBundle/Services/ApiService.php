<?php

namespace Becowo\ApiBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Becowo\CoreBundle\Entity\Event;

class ApiService
{
    private $em = null;
    private $FB_API_ID = null;
    private $FB_API_SECRET = null;
    private $WsService = null;

    public function __construct(EntityManager $em, $FB_API_ID, $FB_API_SECRET, $WsService)
    {
        $this->em = $em;
        $this->FB_API_ID = $FB_API_ID;
        $this->FB_API_SECRET = $FB_API_SECRET;
        $this->WsService = $WsService;
    }

    public function getApiEventsParam()
    {
        $repo = $this->em->getRepository('BecowoApiBundle:ApiEvents');
        return $repo->findApiEventsParam();
    }

    public function getFacebookPageEvents($FB_PAGE_ID, $sinceDate)
    {
        $FB_API_GRAPH_URL = 'https://graph.facebook.com';

        // Construction de l'URL à appeler pour récupérer une APP access_token
        $url = $FB_API_GRAPH_URL.'/oauth/access_token?client_id='.$this->FB_API_ID.'&client_secret='.$this->FB_API_SECRET.'&grant_type=client_credentials';
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
                $url = $FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/events?access_token='.$access_token.'&format=json&since='.$sinceDate;
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
        return $events;
            
    }

    public function saveFacebookPageEvents($events, $facebookPageId, $ws)
    {


        foreach($events as $e)
        {
            $event = New Event();
            $event->setTitle($e->name);
            $event->setDescription($e->description);
            $event->setStartDate(new \DateTime($e->start_time));
            $event->setEndDate(new \DateTime($e->end_time));

            // On vérifie que l'event a bien lieu dans le ws correspondant
            if($e->place->id == $facebookPageId) 
            {
                $event->setWorkspace($ws);
            }

            $this->em->persist($event);
        }

        $this->em->flush();
        
    }

}
