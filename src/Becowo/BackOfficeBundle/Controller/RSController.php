<?php

namespace Becowo\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RSController extends Controller
{
  public function overviewAction(Request $request)
  {
  	$service = $this->get('app.api');
    $becowoPageID = "664800930325388";
    $token = $service->getFacebookPageToken($becowoPageID);

    $FBinsightsLifetime = $service->getFacebookInsightsLifetime($becowoPageID, $token);

    return $this->render('BackOffice/RS/overview.html.twig', array('FBinsightsLifetime' => $FBinsightsLifetime));
  }

  public function facebookAction(Request $request)
  {
    $service = $this->get('app.api');
    $becowoPageID = "664800930325388";
    $token = $service->getFacebookPageToken($becowoPageID);

    $FBinsightsPerDay = $service->getFacebookInsightsPerDay($becowoPageID, $token);
    $FBPostInsights = $service->getFacebookPostsInsights($becowoPageID, $token);
    $FBinsightsLifetime = $service->getFacebookInsightsLifetime($becowoPageID, $token);

    return $this->render('BackOffice/RS/facebook.html.twig', array('FBinsightsPerDay' => $FBinsightsPerDay, 'FBPostInsights' => $FBPostInsights,'FBinsightsLifetime' => $FBinsightsLifetime));
  }

  public function twitterAction(Request $request)
  {
    $service = $this->get('app.api');

    $token = $service->getTwitterToken();

    dump($token);
    return $this->render('BackOffice/RS/twitter.html.twig');
  }
}
