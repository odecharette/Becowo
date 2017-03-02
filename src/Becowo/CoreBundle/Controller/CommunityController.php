<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommunityController extends Controller
{
  
  public function communityAction(Request $request, $limit=9)
  {
    $MemberService = $this->get('app.member');
    // $members = $MemberService->getActiveMembersByFillRate(50);

    $em = $this->getDoctrine()->getManager();
    $queryBuilder = $em->getRepository('BecowoMemberBundle:Member')->createQueryBuilder('m');

    $queryBuilder->select(
      'm.id AS id',
      'm.urlProfilePicture AS urlProfilePicture',
      'm.signedUpWith AS signedUpWith',
      'm.job AS job',
      'm.firstname AS firstname',
      'm.name AS name'
      );

    // $queryBuilder->leftJoin('BecowoCoreBundle:Workspace', 'w', 'WITH', 'e.workspace = w')
    //             ;

    $queryBuilder->andWhere('m.isDeleted = false')
                ->andWhere('m.fillRate >= 50')
                ->orderBy('m.fillRate', 'desc');

    $query = $queryBuilder->getQuery();

    $paginator  = $this->get('knp_paginator');

    $listCoworkers = $paginator->paginate(
        $query, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        $limit/*limit per page*/
    );
    
    
    return $this->render('Community/coworkers.html.twig', array('listCoworkers' => $listCoworkers));
  }


  public function eventsAction(Request $request, $limit=6)
  {
    $wsService = $this->get('app.workspace');
    $WSList = $wsService->getListOfWsWithEvents();

    $em = $this->getDoctrine()->getManager();

    $queryBuilder = $em->getRepository('BecowoCoreBundle:Event')->createQueryBuilder('e');

    $queryBuilder->select(
      'e.id AS id',
      'e.title AS title', 
      'e.startDate AS startDate', 
      'e.endDate AS endDate', 
      'e.description AS description',
      'e.picture AS picture',
      'c.name as CategoryName',
      'w.name as WsName',
      'w.street as WsStreet',
      'w.postCode as WsPostCode',
      'w.city as WsCity',
      'r.name as WsRegion'
      );

    $queryBuilder->leftJoin('BecowoCoreBundle:Workspace', 'w', 'WITH', 'e.workspace = w')
                 ->leftJoin('BecowoCoreBundle:EventCategory', 'c', 'WITH', 'e.category = c')
                 ->leftJoin('BecowoCoreBundle:Region', 'r', 'WITH', 'w.region = r')
                ;

    $queryBuilder->andWhere('w.isDeleted = false')
                 ->andWhere('w.isVisible = true');

    $WsName = $request->query->get('WsName');
    if($WsName != null)
    {
      $queryBuilder->andWhere('w.name = :WsName')
                  ->setParameter('WsName', $WsName);
    }

    $query = $queryBuilder->getQuery();

    $paginator  = $this->get('knp_paginator');

    $listEvents = $paginator->paginate(
        $query, /* query NOT result */
        $request->query->getInt('page', 1)/*page number*/,
        $limit/*limit per page*/
    );
    
    return $this->render('Community/events.html.twig', array("listEvents" => $listEvents, 'WSList' => $WSList));
  }

}
