<?php

namespace Becowo\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
  public function homeAction(Request $request)
  {
  	$service = $this->get('app.api');
    
    $becowoPageID = "664800930325388";
    $token = $service->getFacebookPageToken($becowoPageID);

    $FBinsightsPerDay = $service->getFacebookInsightsPerDay($becowoPageID, $token);
    $FBinsightsLifetime = $service->getFacebookInsightsLifetime($becowoPageID, $token);
    $FBPostInsights = $service->getFacebookPostsInsights($becowoPageID, $token);

    return $this->render('BackOffice/home.html.twig', array('FBinsightsPerDay' => $FBinsightsPerDay, 'FBinsightsLifetime' => $FBinsightsLifetime, 'FBPostInsights' => $FBPostInsights));
  }



}
