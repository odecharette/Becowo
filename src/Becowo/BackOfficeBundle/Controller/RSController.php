<?php

namespace Becowo\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RSController extends Controller
{
  public function overviewAction(Request $request)
  {
  	$service = $this->get('app.api');
    $token = $service->getFacebookPageToken();

    $FBinsightsLifetime = $service->getFacebookInsightsLifetime($token);

    $tokenTwitter = $service->getTwitterToken();
    $twitterAccountInfo = $service->getTwitterAccountInfo($tokenTwitter);

    return $this->render('BackOffice/RS/overview.html.twig', array('FBinsightsLifetime' => $FBinsightsLifetime, 'twitterAccountInfo' => $twitterAccountInfo));
  }

  public function facebookAction(Request $request)
  {
    $service = $this->get('app.api');
    $token = $service->getFacebookPageToken();

    $FBinsightsPerDay = $service->getFacebookInsightsPerDay($token);
    $FBPostInsights = $service->getFacebookPostsInsights($token);
    $FBinsightsLifetime = $service->getFacebookInsightsLifetime($token);

    return $this->render('BackOffice/RS/facebook.html.twig', array('FBinsightsPerDay' => $FBinsightsPerDay, 'FBPostInsights' => $FBPostInsights,'FBinsightsLifetime' => $FBinsightsLifetime));
  }

  public function twitterAction(Request $request)
  {

    return $this->render('BackOffice/RS/twitter.html.twig');
  }
}
