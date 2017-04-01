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
        $response = \Httpful\Request::get($url)->send();

        $events = null;

        $jsonResponse =json_decode($response);
        $access_token = $jsonResponse->access_token;

        if ($access_token != "") {
            
            $this->logger->notice('getFacebookPageEvents -Token OK for FB_ID : ' . $FB_PAGE_ID);

            // Construction de l'URL à appeler pour récupérer les évènements de la page depuis le 01/01/2017
            $url = $FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/events?access_token='.$access_token.'&format=json&since=2017-01-01';
            // Appel à l'API
            $response = \Httpful\Request::get($url)->send();

            // si data existe, c'est un array() qui contient tous les évènements relatifs à cette page
            if (isset($response->body->data)) {
                $events = $response->body->data;

                $this->logger->notice('getFacebookPageEvents - ' . count($events) . ' events found for FB_ID : ' . $FB_PAGE_ID);                  
            }else if(isset($response->body->error)){
                $this->logger->critical('getFacebookPageEvents - issue with FB_ID : ' . $FB_PAGE_ID . ' : ' . $response->body->error->message);
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
                // $event->setDescription(preg_replace('/[^\p{L}0-9\-]/u', ' ', $e->description));
                $desc = mb_convert_encoding($e->description, 'UTF-8', 'UTF-8');
                $desc = str_replace("\xF0\x9F\x8E\x89", "", $desc);
                
                $event->setDescription($desc);
                
                $event->setStartDate(new \DateTime($e->start_time));
                $event->setEndDate(new \DateTime($e->end_time));
                $event->setFacebookId($e->id);
                $event->setPicture($this->getFacebookEventPicture($e->id)->source);

                // On vérifie que l'event a bien lieu dans le ws correspondant
                // if(isset($e->place->id))
                // {   
                //     if($e->place->id == $facebookPageId) 
                //     {
                //         $event->setWorkspace($ws);
                //     }
                // }else if(isset($e->place->name))
                // {
                //     if(strpos($e->place->name, $ws->getName()) >= 0)
                //     {
                //         $event->setWorkspace($ws);
                //     }
                // }
                //////// Ne marche pas tjs car certaines page FB sont mal configurées (ex wereso paris)
                // du coup on part du principe que l'event est tjs organisé dans l'espace qui le diffuse...
                $event->setWorkspace($ws);

                $this->logger->notice('saveFacebookPageEvents - Event ID ' . $e->id . ' created');

                $this->em->persist($event);
            }
        }

        $this->em->flush();
        
    }

    public function getFacebookEventPicture($eventId)
    {
        $FB_API_GRAPH_URL = 'https://graph.facebook.com';

        $url = $FB_API_GRAPH_URL.'/oauth/access_token?client_id='.$this->FB_API_ID.'&client_secret='.$this->FB_API_SECRET.'&grant_type=client_credentials';
        $response = \Httpful\Request::get($url)->send();

        $jsonResponse =json_decode($response);
        $access_token = $jsonResponse->access_token;

        $picture = null;
        if ($access_token != "") {
            
            $this->logger->notice('getFacebookEventPicture -Token OK');
            
            $url = $FB_API_GRAPH_URL.'/'.$eventId.'?access_token='.$access_token.'&format=json&fields=cover';
            $response = \Httpful\Request::get($url)->send();

            if (isset($response->body->cover)) {
                $picture = $response->body->cover;
                $this->logger->notice('getFacebookEventPicture - picture found for eventId ' . $eventId);
            }
        }
        else {
            $this->logger->critical('getFacebookEventPicture - Bad access token');
            $picture = null;
        }
        return $picture;
    }


}
