<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
  public function homeAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $workspaces = $WsService->getActiveWorkspacesOrderByVoteAvg();

    $wsFullInfo = array();
    $listCities = array();
    foreach ($workspaces as $ws)
    {
      array_push($wsFullInfo, array('ws' => $ws,
        'amenities' => $WsService->getAmenitiesByWorkspace($ws),
        'WsHasOffers' => $WsService->getOffersByWorkspace($ws)
        ));

      array_push($listCities, $ws->getCity());
    }

    $listCities = array_unique($listCities);

    return $this->render('Home/home.html.twig', array('wsFullInfo' => $wsFullInfo, 'listCities' => $listCities));
  }

  public function paginationListAction(Request $request)
  {
    // TEST avec paginator
    $em = $this->getDoctrine()->getManager();

    $queryBuilder = $em->getRepository('BecowoCoreBundle:Workspace')->createQueryBuilder('bp');

    $query = $queryBuilder->getQuery();

    $paginator  = $this->get('knp_paginator');

    $listWS = $paginator->paginate(
        $query, /* query NOT result */
        $request->query->getInt('page')/*page number*/,
        $request->query->getInt('limit', 5)/*limit per page*/
    );
    $listWS->setUsedRoute('becowo_core_list_workspaces');

    return $this->render('Home/WS-list.html.twig',array('listWS' => $listWS));
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
