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
    private $logger = null;

    public function __construct(EntityManager $em, $FB_API_ID, $FB_API_SECRET, $WsService, $logger)
    {
        $this->em = $em;
        $this->FB_API_ID = $FB_API_ID;
        $this->FB_API_SECRET = $FB_API_SECRET;
        $this->WsService = $WsService;
        $this->logger = $logger;
    }

    public function getApiEventsParam()
    {
        $repo = $this->em->getRepository('BecowoApiBundle:ApiEvents');
        return $repo->findApiEventsParam();
    }

    public function getFacebookPageEvents($FB_PAGE_ID)
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

        $events = null;
        // Si on récupère quelque chose
        if (isset($response->body) && !empty($response->body)) {
            
            $access_token =$response->body;
            
            if (!empty($access_token)) {
                $this->logger->info('getFacebookPageEvents -Token OK for FB_ID : ' . $FB_PAGE_ID);

                // Construction de l'URL à appeler pour récupérer les évènements de la page depuis le 01/01/2017
                $url = $FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/events?access_token='.$access_token.'&format=json&since=2017-01-01';
                // Appel à l'API
                $response = \Httpful\Request::get($url)->send();
                // si data existe, c'est un array() qui contient tous les évènements relatifs à cette page
                if (isset($response->body->data)) {
                    // affichage des données récupérées
                    $events = $response->body->data;
                    $this->logger->info('getFacebookPageEvents - ' . count($events) . ' events found for FB_ID : ' . $FB_PAGE_ID);                  
                }else if(isset($response->body->error)){
                    $this->logger->critical('getFacebookPageEvents - issue with FB_ID : ' . $FB_PAGE_ID . ' : ' . $response->body->error->message);
                }
            }
            else {
                $this->logger->critical('getFacebookPageEvents - No token for FB_ID : ' . $FB_PAGE_ID);

                $events = null;
            }
        }
        else {

            $this->logger->critical('getFacebookPageEvents - Bad access token for FB_ID : ' . $FB_PAGE_ID);

            $events = null;
        }
        return $events;
            
    }

    public function saveFacebookPageEvents($events, $facebookPageId, $ws)
    {

        foreach($events as $e)
        {
            $existingEvent = $this->WsService->getEventByFacebookId($e->id);

            // On créer l'event en BDD que s'il n'existe pas déjà
            if($existingEvent == null)
            {
                $event = New Event();
                $event->setTitle($e->name);
                $event->setDescription(preg_replace('/[^\p{L}0-9\-]/u', ' ', $e->description));
                $event->setStartDate(new \DateTime($e->start_time));
                $event->setEndDate(new \DateTime($e->end_time));
                $event->setFacebookId($e->id);
                $event->setPicture($this->getFacebookEventPicture($e->id)->source);

                // On vérifie que l'event a bien lieu dans le ws correspondant
                if(isset($e->place->id))
                {   
                    if($e->place->id == $facebookPageId) 
                    {
                        $event->setWorkspace($ws);
                    }
                }else if(isset($e->place->name))
                {
                    if(strpos($e->place->name, $ws->getName()) >= 0)
                    {
                        $event->setWorkspace($ws);
                    }
                }

                $this->logger->info('saveFacebookPageEvents - Event ID ' . $e->id . ' created');

                $this->em->persist($event);
            }
        }

        $this->em->flush();
        
    }

    public function getFacebookEventPicture($eventId)
    {
        $FB_API_GRAPH_URL = 'https://graph.facebook.com';

        $url = $FB_API_GRAPH_URL.'/oauth/access_token?client_id='.$this->FB_API_ID.'&client_secret='.$this->FB_API_SECRET.'&grant_type=client_credentials';
        $response = \Httpful\Request::get($url)->parseWith(function($body) {
            $access_token = str_replace("access_token=", "", $body); 
            return $access_token;
        })->send();

        $picture = null;
        if (isset($response->body) && !empty($response->body)) {
            
            $this->logger->info('getFacebookEventPicture -Token OK');

            $access_token =$response->body;
            
            if (!empty($access_token)) {
                $url = $FB_API_GRAPH_URL.'/'.$eventId.'?access_token='.$access_token.'&format=json&fields=cover';
                $response = \Httpful\Request::get($url)->send();

                if (isset($response->body->cover)) {
                    $picture = $response->body->cover;
                    $this->logger->info('getFacebookEventPicture - picture found for eventId ' . $eventId);
                }
            }
            else {
                $this->logger->critical('getFacebookEventPicture - No token');
                $picture = null;

            }
        }
        else {
            $this->logger->critical('getFacebookEventPicture - Bad access token');
            $picture = null;
        }
        return $picture;
    }

}
