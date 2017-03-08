<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\CommunityNetwork;
use Becowo\CoreBundle\Entity\CommunityNetworkHasMember;
use Becowo\CoreBundle\Form\Type\CommunityNetworkType;
use Becowo\CoreBundle\Form\Type\CommunityNetworkHasMemberType;

class CommunityController extends Controller
{
  public function networkAction(Request $request, $networkId)
  {
    $WsService = $this->get('app.workspace');

    $network = $WsService->getAllCommunityNetwork();

    $members = $WsService->getMembersByNetworkId($networkId);

    $currentNetwork = $WsService->getCommunityNetworkById($networkId)[0];

    $newNetwork = new CommunityNetwork();
    $newNetwork->setAdminMember($this->getUser());
    $form = $this->get('form.factory')->create(CommunityNetworkType::class, $newNetwork);

    $newCommunityMember = new CommunityNetworkHasMember();
    $newCommunityMember->setCommunityNetwork($currentNetwork);
    $formMember = $this->get('form.factory')->create(CommunityNetworkHasMemberType::class, $newCommunityMember);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($newNetwork);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Le réseau a bien été crée');

      return $this->redirectToRoute('becowo_manager_community', array('networkId' => $newNetwork->getId()));
    }

    if ($request->isMethod('POST') && $formMember->handleRequest($request)->isValid()) {
      
      $em = $this->getDoctrine()->getManager();
      $em->persist($newCommunityMember);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Le coworker a bien été ajouté au réseau');

      return $this->redirectToRoute('becowo_manager_community', array('networkId' => $newCommunityMember->getCommunityNetwork()->getId()));
    }

    return $this->render('Manager/community/network.html.twig', array('network' => $network, 'currentNetwork' => $currentNetwork, 'members' => $members, 'form' => $form->createView(), 'formMember' => $formMember->createView()));
  }
  
}
