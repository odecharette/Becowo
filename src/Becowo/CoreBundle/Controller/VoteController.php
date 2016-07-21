<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\VoteType;
use Becowo\CoreBundle\Entity\Vote;

class VoteController extends Controller
{

  public function voteAction(Request $request)
  {
    $WsService = $this->get('app.workspace');
    $ws = $WsService->getWorkspaceByName($request->get('name')); 

  	$vote = new Vote();

    $form = $this->createForm(VoteType::class, $vote);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid() ) { 

        $vote->setWorkspace($ws);
        $vote->setMember($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($vote);
        $em->flush();
        
        return $this->redirectToRoute('becowo_core_vote', array('name' => $request->get('name')));
      }

    return $this->render('Vote/vote.html.twig', array(
      'form' => $form->createView()));

  }


}