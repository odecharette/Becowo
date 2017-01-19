<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
  public function homeAction()
  {
    return $this->render('Home/home.html.twig');
  }

  public function mobileAction()
  {
    // This view in called only on mobiles
  
    $WsService = $this->get('app.workspace');
    $WswithVote = $WsService->getActiveWorkspacesOrderByVoteAvg(); 
    $AllActiveWs = $WsService->getActiveWorkspaces();

    // En queryBuilder impossible de faire une requet en Union donc on récup 
    // 1/ Tous les WS qui ont un vote, trié sur socreAVg en Desc
    // 2/ Tous les WS
    // 3/ On merge les 2 résultats
    // 4/ On enlève les doublons
    $workspaces = array_merge($WswithVote, $AllActiveWs);
    $workspaces = array_unique($workspaces);

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
