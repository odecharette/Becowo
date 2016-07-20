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
    // $WsService = $this->get('app.workspace');
    // $ws = $WsService->getWorkspaceByName($request->get('YellowWorking')); // TO DO recup current WS

  	$vote = new Vote();

    $form = $this->createForm(VoteType::class, $vote);
dump($form);
      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid() ) {  // TO DO renvoi false...

        // $vote->setWorkspace($ws);
        // $vote->setMember($this->getUser());
        $vote->setScoreAvg("1"); // TO DO 

        $em = $this->getDoctrine()->getManager();
        $em->persist($vote);
        $em->flush();
        
        return $this->redirectToRoute('becowo_core_vote');
      }

    return $this->render('Vote/vote.html.twig', array(
      'form' => $form->createView()));

  }


}