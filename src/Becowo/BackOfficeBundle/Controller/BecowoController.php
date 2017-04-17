<?php

namespace Becowo\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BecowoController extends Controller
{
  public function bddAction(Request $request)
  {
  	$statService = $this->get('app.stat');

  	$activeWs = $statService->getCountActiveWorkspaces();
  	$activeWsByOffer = $statService->getCountActiveWorkspacesByOffer();

  	$activeMembers = $statService->getCountActiveMembers();
  	$activeMembersBySignedUpWith = $statService->getCountActiveMembersBySignedUpWith();

  	$events = $statService->getCountEvents();
  	$eventsByWorkspace = $statService->getCountEventsByWorkspace();

    return $this->render('BackOffice/Becowo/bdd.html.twig', array(
    	'activeWs' => $activeWs,
    	'activeWsByOffer' => $activeWsByOffer,
    	'activeMembers' => $activeMembers,
    	'activeMembersBySignedUpWith' => $activeMembersBySignedUpWith,
    	'events' => $events,
    	'eventsByWorkspace' => $eventsByWorkspace));
  }


}
