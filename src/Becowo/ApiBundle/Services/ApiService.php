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

    public function getFacebookInsights($FB_PAGE_ID)
    {
        $FB_API_GRAPH_URL = 'https://graph.facebook.com';

        // Construction de l'URL à appeler pour récupérer une APP access_token
        // $url = $FB_API_GRAPH_URL.'/oauth/access_token?client_id='.$this->FB_API_ID.'&client_secret='.$this->FB_API_SECRET.'&grant_type=client_credentials&scope=manage_pages';
        // echo $url . "\n";
        // // Appel à l'API
        // $response = \Httpful\Request::get($url)->send();
        // echo $response;

        // echo "\n\n";

        // $jsonResponse =json_decode($response);
        // $access_token = $jsonResponse->access_token;
        // // Construction de l'URL à appeler pour récupérer une PAGE access_token
        // $url = $FB_API_GRAPH_URL. '/' . $FB_PAGE_ID.'?fields=access_token&access_token='.$access_token;
        // echo $url . "\n";
        // // Appel à l'API
        // $response = \Httpful\Request::get($url)->send();
        // echo "page access \n";
        // echo $response;

        // $jsonResponse =json_decode($response);
        // $access_token = $jsonResponse->access_token;


        // Construction de l'URL à appeler pour récupérer une PAGE access_token
        // l'access token de l'URL est généré via https://smashballoon.com/custom-facebook-feed/docs/get-extended-facebook-user-access-token/ A priori il est permanent
        $url = $FB_API_GRAPH_URL. '/me/accounts?fields=access_token,id,name&access_token=EAALgwfIjMTIBAO8jluUtiHPXpo5wYUSztGlmnz9cOiDZBdCj85A02mIySgAZBrlaANKehDP7MzF7qt43k0Xw20cZAb7R9ZBuSCmG0ZB7w3h0zHZAluyOKx2XTKPbHEZBBQXSK4nruq5Fcz8rgKVMOHhk4N5jZB3d3KUZD';


        ////////// token V1 : EAALgwfIjMTIBAIZCA3DEDPnhroRhZAUlO6W7yhpZAbVoAY4oZBrB5hDISckTaFrOQayLHIDYewZACeIzeruKkS3U9Oz19cvR1U0OpXDuQ2UYt1wXSifO8K8pQoU4fnznxkQVebFZCzxslio03hUoDg

        ///////// token V2 : EAALgwfIjMTIBAO8jluUtiHPXpo5wYUSztGlmnz9cOiDZBdCj85A02mIySgAZBrlaANKehDP7MzF7qt43k0Xw20cZAb7R9ZBuSCmG0ZB7w3h0zHZAluyOKx2XTKPbHEZBBQXSK4nruq5Fcz8rgKVMOHhk4N5jZB3d3KUZD

        // echo $url . "\n";
        // Appel à l'API
        $response = \Httpful\Request::get($url)->send();
        // echo "page access \n";
        // dump($response);

        $stats = null;

        $jsonResponse =json_decode($response);
//         $access_token = $jsonResponse->access_token;

//         if ($access_token != "") {
            
//             $this->logger->notice('getFacebookInsights -Token OK for FB_ID : ' . $FB_PAGE_ID);

//             // Construction de l'URL à appeler pour récupérer les stats de la page
//             $url = $FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/insights?access_token=EAACEdEose0cBAOYPhtjXZB3jVG7RBJbRJdTRVX4BPHOMJqxpTZApV5UWv7zBp0hBzJ0vW5HJZBZAp6GlqwifLkNFjDUdZAqwbcAR4Ke1h8C3pAjJ7jokFutYMVk74G29LteKpG0C8qD3YPGCXS9cSldVnQJB3a2DSej9FeEFWO8eXtFWAFrqujny0pKQ0YCkZD' . '&metric=page_fans,page_stories';
//             // Appel à l'API
//             $response = \Httpful\Request::get($url)->send();
// echo $response . "\n\n";
//             // si data existe, c'est un array() qui contient tous les stats relatifs à cette page
//            if (isset($response->body->data)) {
                $rep = $response->body->data;
                // dump($rep);
                foreach ($rep as $r) {
                    if($r->name == "Becowo")
                    {
                        $pageToken = $r->access_token;
                        // echo $pageToken . "\n";
                    }
                }
            // echo "\n\npage token : \n";
            // echo $pageToken;

            // Construction de l'URL à appeler pour récupérer les stats de la page
            // LAST 28 days STATS
            $url = $FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/insights?access_token=' . $pageToken . '&metric=page_stories_by_story_type&period=day';
            // Appel à l'API
            $response = \Httpful\Request::get($url)->send();

            dump($response->body->data);

            // LIFETIME STATS
            $url = $FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/insights?access_token=' . $pageToken . '&metric=page_fans,page_fans_city,page_fans_country,page_fans_gender_age&since=yesterday';
            // Appel à l'API
            $response = \Httpful\Request::get($url)->send();

             // dump($response->body->data);
            foreach ($response->body->data as $d) {
            // dump($d);
            switch ($d->name) {
                case 'page_fans':
                    echo $d->title . " : " . $d->values[0]->value ;
                    break;
                case 'page_fans_gender_age':
                    echo $d->title . " : ";
                    $items = get_object_vars($d->values[0]->value);
                    foreach ($items as $age => $nb) {
                        echo $age . " : " . $nb . "\n";
                    }
                    break;
                case 'page_fans_country':
                    echo $d->title . " : ";
                    $items = get_object_vars($d->values[0]->value);
                    foreach ($items as $country => $nb) {
                        // Get Country name
                        $url = $FB_API_GRAPH_URL.'/search?type=adgeolocation&location_types=country&match_country_code=true&q=' . $country . '&access_token=' . $pageToken;
                        $response = \Httpful\Request::get($url)->send();
                        echo $response->body->data[0]->name . " : " . $nb . "\n";
                    }
                    break;
                case 'page_fans_city':
                    echo $d->title . " : ";
                    $items = get_object_vars($d->values[0]->value);
                    foreach ($items as $city => $nb) {
                        echo $city . " : " . $nb . "\n";
                    }
                    echo "\n";

                    break;
               default:
                   # code...
                   break;
            }
        }
echo "\n\n\n\n";


            // POSTS STATS
            $url = $FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/posts?access_token=' . $pageToken;
            // Appel à l'API
            $response = \Httpful\Request::get($url)->send();
            echo "\n nb de posts : " . count($response->body->data) . "\n";
        //    dump($response->body->data);

            foreach ($response->body->data as $d) {
                $url = $FB_API_GRAPH_URL.'/'. $d->id .'?fields=message,story,shares,name,permalink_url,type&access_token=' . $pageToken;
                $response = \Httpful\Request::get($url)->send();

                //dump($response->body);
                if(isset($response->body->message)){
                    echo "message : " . $response->body->message . "\n";
                }elseif(isset($response->body->story)){
                    echo "story : " . $response->body->story . "\n";
                };
                echo "nom : " . $response->body->name . "\n";
                echo "type : " . $response->body->type . "\n";
                echo "link : " . $response->body->permalink_url . "\n";
                echo "nb shares : ";
                if(isset($response->body->shares))
                {
                    echo $response->body->shares->count;
                }else{
                    echo "0";
                }
                echo "\n";

                $url = $FB_API_GRAPH_URL.'/'. $d->id .'/likes?fields=total_count&summary=true&access_token=' . $pageToken;
                $response = \Httpful\Request::get($url)->send();
                echo "Nb de likes : ";
                echo $response->body->summary->total_count . "\n";

            }

                // $this->logger->notice('getFacebookInsights - ' . count($stats) . ' stats found for FB_ID : ' . $FB_PAGE_ID);                  
            // }else if(isset($response->body->error)){
            //     $this->logger->critical('getFacebookInsights - issue with FB_ID : ' . $FB_PAGE_ID . ' : ' . $response->body->error->message);
            // }
        // }
        // else {

        //     $this->logger->critical('getFacebookInsights - Bad access token for FB_ID : ' . $FB_PAGE_ID);

        //     $stats = null;
        // }
        return $stats;

    }

}
