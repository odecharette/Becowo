<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\Type\VoteType;
use Becowo\CoreBundle\Entity\Vote;
use Symfony\Component\HttpFoundation\Response;

class VoteController extends Controller
{

  public function voteWSdevenirZenAction(Request $request)
  {
    if ($request->isMethod('POST'))
    {
      $WsService = $this->get('app.workspace');
      $ws = $WsService->getWorkspaceById($request->get('id'));

      $vote = new Vote();
      $vote->setWorkspace($ws);
      $vote->setMember($this->getUser());
      $vote->setEmailVote($request->request->get('emailVote'));
      $vote->setDevenirZen('1');

      $em = $this->getDoctrine()->getManager();
      $em->persist($vote);
      $em->flush();

      return $this->redirectToRoute('becowo_core_vote_zen', array('id' => $request->get('id')));
    }

     return $this->redirectToRoute('becowo_core_homepage');
  }

}
