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
        $this->FB_API_GRAPH_URL = 'https://graph.facebook.com';
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

    public function getFacebookPageToken($FB_PAGE_ID)
    {
        // Construction de l'URL à appeler pour récupérer une PAGE access_token
        // l'access token de l'URL est généré via https://smashballoon.com/custom-facebook-feed/docs/get-extended-facebook-user-access-token/ A priori il est permanent
        $url = $this->FB_API_GRAPH_URL. '/me/accounts?fields=access_token,id,name&access_token=EAALgwfIjMTIBAO8jluUtiHPXpo5wYUSztGlmnz9cOiDZBdCj85A02mIySgAZBrlaANKehDP7MzF7qt43k0Xw20cZAb7R9ZBuSCmG0ZB7w3h0zHZAluyOKx2XTKPbHEZBBQXSK4nruq5Fcz8rgKVMOHhk4N5jZB3d3KUZD';
        $response = \Httpful\Request::get($url)->send();

        $rep = $response->body->data;
        foreach ($rep as $r) {
            if($r->name == "Becowo")
            {
                $pageToken = $r->access_token;
            }
        }
        return $pageToken;
    }

    public function getFacebookInsightsPerDay($FB_PAGE_ID, $pageToken)
    {
        // LAST 28 days STATS
        $url = $this->FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/insights?access_token=' . $pageToken . '&metric=page_stories_by_story_type&period=day';
        $response = \Httpful\Request::get($url)->send();

        return $response->body->data;
    }

    public function getFacebookInsightsLifetime($FB_PAGE_ID, $pageToken)
    {
        // LIFETIME STATS
        $url = $this->FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/insights?access_token=' . $pageToken . '&metric=page_fans,page_fans_city,page_fans_country,page_fans_gender_age&since=yesterday';
        $response = \Httpful\Request::get($url)->send();

        $results = array();
        foreach ($response->body->data as $d) {
            switch ($d->name) {
                case 'page_fans':
                    // echo $d->title . " : " . $d->values[0]->value ;
                    $tab = array();
                    $tab[$d->title] = $d->values[0]->value;
                    array_push($results, $tab);
                    break;
                case 'page_fans_gender_age':
                    // echo $d->title . " : ";
                    $items = get_object_vars($d->values[0]->value);
                    $tab = array();
                    $tab[$d->title] = $items;
                    array_push($results, $tab);
                    // foreach ($items as $age => $nb) {
                    //     echo $age . " : " . $nb . "\n";
                    // }
                    break;
                // case 'page_fans_country':
                //     $items = get_object_vars($d->values[0]->value);
                //     $statCountries = array();
                //     foreach ($items as $country => $nb) {
                //         // Get Country name
                //         $url = $this->FB_API_GRAPH_URL.'/search?type=adgeolocation&location_types=country&match_country_code=true&q=' . $country . '&access_token=' . $pageToken;
                //         $response = \Httpful\Request::get($url)->send();
                //         $statCountries[$response->body->data[0]->name] = $nb;
                //     }
                //     $tab = array();
                //     $tab[$d->title] = $statCountries;
                //     array_push($results, $tab);
                //     break;
                case 'page_fans_city':
                    $items = get_object_vars($d->values[0]->value);
                    $statCities = array();
                    foreach ($items as $city => $nb) {

                        $temp = explode(",", $city);
                        if(count($temp) == 4)
                        {
                            $pays = $temp[3];
                            $region = $temp[2];
                            $ville = $temp[0];
                        }
                        elseif(count($temp) == 3)
                        {
                            $pays = $temp[2];
                            $region = $temp[1];
                            $ville = $temp[0];
                        }else{
                            $pays = $temp[1];
                            $region = "Toutes";
                            $ville = $temp[0];
                        }

                        // $p = array();
                        // $r = array();
                        // $v = array();
                        // $v[$ville] = $nb;
                        // $r[$region] = $v;
                        // $p[$pays] = $r;
                        $tab = array();
                        $tab['country'] = $pays;
                        $tab['region'] = $region;
                        $tab['city'] = $ville;
                        $tab['nb'] = $nb;
                        array_push($statCities, $tab);
                        
                    }
                    $tab = array();
                    $tab[$d->title] = $statCities;
                    array_push($results, $tab);

                    break;
               default:
                   # code...
                   break;
            }
        }
        return $results;
    }

    public function getFacebookPostsInsights($FB_PAGE_ID, $pageToken)
    {

        // POSTS STATS
        $url = $this->FB_API_GRAPH_URL.'/'.$FB_PAGE_ID.'/posts?access_token=' . $pageToken;
        $response = \Httpful\Request::get($url)->send();

        $results = array();
        $tab = array();
        $tab['totalPosts'] = count($response->body->data);
        array_push($results, $tab);
        // echo "\n nb de posts : " . count($response->body->data) . "\n";

        $post = array();
        foreach ($response->body->data as $d) {
            $url = $this->FB_API_GRAPH_URL.'/'. $d->id .'?fields=message,story,shares,name,permalink_url,type&access_token=' . $pageToken;
            $response = \Httpful\Request::get($url)->send();

            if(isset($response->body->message)){
                $post['message'] = $response->body->message;
                // echo "message : " . $response->body->message . "\n";
            }elseif(isset($response->body->story)){
                $post['story'] = $response->body->story;
                // echo "story : " . $response->body->story . "\n";
            };
            $post['nom'] = $response->body->name;
            $post['type'] = $response->body->type;
            $post['link'] = $response->body->permalink_url;
            // echo "nom : " . $response->body->name . "\n";
            // echo "type : " . $response->body->type . "\n";
            // echo "link : " . $response->body->permalink_url . "\n";
            // echo "nb shares : ";
            if(isset($response->body->shares))
            {

                $post['shares'] = $response->body->shares->count;
                // echo $response->body->shares->count;
            }else{
                $post['shares'] = "0";
                // echo "0";
            }
            // echo "\n";

            $url = $this->FB_API_GRAPH_URL.'/'. $d->id .'/likes?fields=total_count&summary=true&access_token=' . $pageToken;
            $response = \Httpful\Request::get($url)->send();
            // echo "Nb de likes : ";
            // echo $response->body->summary->total_count . "\n";
            $post['likes'] = $response->body->summary->total_count;

            array_push($results, $post);
        }

        return $results;

    }

}
