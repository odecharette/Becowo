<?php

namespace Becowo\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;

class EventsController extends Controller
{
  private $em = null;
  private $appApi = null;

  public function __construct(EntityManager $em=null, $appApi=null)
  {
      $this->em = $em;
      $this->appApi = $appApi;
  }

  public function createFacebookPageEventsAction()
  {
    $eventsParam = $this->appApi->getApiEventsParam();

    // On va chercher les FB events de tous les WS renseignés dans la table ApiEvents, depuis la dernière update date
    foreach ($eventsParam as $param) {
        
        $events = $this->appApi->getFacebookPageEvents($param->getFacebookPageId());
        
        if($events != null)
        {
            $this->appApi->saveFacebookPageEvents($events, $param->getFacebookPageId(), $param->getWorkspace());
        }
    }

	return 'Done : please read log in var/log/api';
  }


  

}
