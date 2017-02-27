<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
  public function homeAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $listCities = $WsService->getListOfActiveCities();

    return $this->render('Home/home.html.twig', array('listCities' => $listCities));
  }

  public function paginationListAction(Request $request, $limit=5)
  {
    $WsService = $this->get('app.workspace');
    $em = $this->getDoctrine()->getManager();

    $queryBuilder = $em->getRepository('BecowoCoreBundle:Workspace')->createQueryBuilder('w');

    $queryBuilder->select(
      'w.id AS id', 
      'w.name AS name', 
      'w.city AS city',
      'w.favoritePictureUrl AS favoritePictureUrl',
      'w.lowestPrice AS lowestPrice',
      'w.voteAverage AS voteAverage',
      'w.descriptionBonus AS descriptionBonus',
      'r.name AS region',
      'c.name AS category',
      'o.name AS offer');

    $queryBuilder->leftJoin('BecowoCoreBundle:WorkspaceHasOffer', 'who', 'WITH', 'who.workspace = w')
                ->leftJoin('BecowoCoreBundle:Offer', 'o', 'WITH', 'o = who.offer')
                ->leftJoin('BecowoCoreBundle:Region', 'r', 'WITH', 'r = w.region')
                ->leftJoin('BecowoCoreBundle:WorkspaceCategory', 'c', 'WITH', 'w.category = c')
                ;

    if($request->query->get('city') != null)
    {
      $values = explode(',',$request->query->get('city'));
      $queryBuilder->andWhere('w.city IN (:city)')
                  ->setParameter('city', $values);
    }

    if($request->query->get('category') != null)
    {
      $values = explode(',',$request->query->get('category'));
      $queryBuilder->andWhere('c.name IN (:category)')
                  ->setParameter('category', $values);
    }

    $queryBuilder->andWhere('w.isDeleted = false')
                ->andWhere('w.isVisible = true')
                ->orderBy('w.voteAverage', 'DESC');

    $query = $queryBuilder->getQuery();

    $paginator  = $this->get('knp_paginator');

    $listWS = $paginator->paginate(
        $query, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        $limit/*limit per page*/
    );
    $listWS->setUsedRoute('becowo_core_list_workspaces');

    $wsAmenities = array();
    foreach ($listWS->getItems() as $ws)
    {
      array_push($wsAmenities, array('ws' => $ws['id'],
        'amenities' => $WsService->getAmenitiesByWorkspaceId($ws['id']),
        ));
    }

    return $this->render('Home/WS-list.html.twig',array('listWS' => $listWS, 'wsAmenities' => $wsAmenities));
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
