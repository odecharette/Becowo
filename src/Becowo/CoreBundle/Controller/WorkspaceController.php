<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Becowo\CoreBundle\Entity\Vote;
use Becowo\CoreBundle\Entity\Comment;
use Becowo\CoreBundle\Form\CommentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class WorkspaceController extends Controller
{
  public function viewAction($name, Request $request)
  {
  	// $em = $this->getDoctrine()->getManager();  // a enlever qd tt en service

    $WsService = $this->get('app.workspace');

    $ws = $WsService->getWorkspaceByName($name);
    $pictures = $WsService->getPicturesByWorkspace($name);
    $pictureFavorite = $WsService->getFavoritePictureByWorkspace($name);
    $pictureLogo = $WsService->getLogoByWorkspace($name);
    $listEvents = $WsService->getEventsByWorkspace($ws);
    $listOffices = $WsService->getOfficesByWorkspace($ws);

  	return $this->render('Workspace/view.html.twig', 
      array('ws' => $ws, 
        'listEvents' => $listEvents, 
        'pictures' => $pictures, 
        'pictureFavorite' => $pictureFavorite, 
        'pictureLogo' => $pictureLogo,
        'listOffices' => $listOffices));
  }

  public function voteAction($vote, $name, $member)
  {
    // TO DO IMPORTANT : revoir tout car ici je charge en dur le vote pour un WS et un membre
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('BecowoCoreBundle:Workspace');
    $w = $repo->findOneByName('Mutualab');

    $repo = $em->getRepository('BecowoMemberBundle:Member');
    $m = $repo->findOneByFirstname('Olivia');


    $newVote = new Vote();
    $newVote->setScore1($vote);
    $newVote->setWorkspace($w);
    $newVote->setMember($m);

    $em->persist($newVote);
    $em->flush();

    

    return $this->redirectToRoute('becowo_core_workspace', array('name' => $name));
  }

}