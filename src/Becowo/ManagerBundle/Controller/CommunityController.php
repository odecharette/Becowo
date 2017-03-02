<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommunityController extends Controller
{
  public function networkAction(Request $request, $networkId)
  {
    $WsService = $this->get('app.workspace');

    $network = $WsService->getAllCommunityNetwork();

    $members = $WsService->getMembersByNetworkId($networkId);

    return $this->render('Manager/community/network.html.twig', array('network' => $network, 'members' => $members));
  }
  
}
