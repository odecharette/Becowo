<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
  public function homeAction()
  {
    $WsService = $this->get('app.workspace');
    $workspaces = $WsService->getActiveWorkspacesOrderByVoteAvgAndWithoutVote();

    $wsFullInfo = array();
    $listCities = array();
    foreach ($workspaces as $ws)
    {
      array_push($wsFullInfo, array('ws' => $ws,
        'lowestPrice' => $WsService->getLowestPriceByWorkspace($ws),
        'amenities' => $WsService->getAmenitiesByWorkspace($ws),
        'favoritePicture' => $WsService->getFavoritePictureUrlByWorkspace($ws->getName()),
        'averageVote' => round($WsService->getAverageVoteByWorkspace($ws), 0),
        'WsHasOffers' => $WsService->getOffersByWorkspace($ws),
        'category' => $ws->getCategory()->getName()));

      array_push($listCities, $ws->getCity());
    }

    $listCities = array_unique($listCities);

dump($wsFullInfo);

    return $this->render('Home/home.html.twig', array('wsFullInfo' => $wsFullInfo, 'listCities' => $listCities));
  }

  public function mobileAction()
  {
    // This view in called only on mobiles
  
    $WsService = $this->get('app.workspace');
    $workspaces = $WsService->getActiveWorkspacesOrderByVoteAvgAndWithoutVote();

    $wsFullInfo = array();
    foreach ($workspaces as $w)
    {
      array_push($wsFullInfo, array('ws' => $w,
        'lowestPrice' => $WsService->getLowestPriceByWorkspace($w),
        'amenities' => $WsService->getAmenitiesByWorkspace($w),
        'favoritePicture' => $WsService->getFavoritePictureUrlByWorkspace($w->getName()),
        'averageVote' => round($WsService->getAverageVoteByWorkspace($w), 0),
        'WsHasOffers' => $WsService->getOffersByWorkspace($w)) );
    }

    return $this->render('Home/ws-list-mobile.html.twig', array('wsFullInfo' => $wsFullInfo));
  }

  public function communityAction()
  {
    $MemberService = $this->get('app.member');
    $members = $MemberService->getActiveMembersByFillRate(50);
    
    return $this->render('Home/community.html.twig', array('members' => $members));
  }

}
