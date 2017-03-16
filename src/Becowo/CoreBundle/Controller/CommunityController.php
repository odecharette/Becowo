<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommunityController extends Controller
{
  
  public function communityAction(Request $request, $limit=9)
  {    
    return $this->render('Community/coworkers.html.twig');
  }


  public function eventsAction(Request $request, $limit=5)
  {
    return $this->render('Community/events.html.twig');
  }

}
