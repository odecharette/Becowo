<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\CoreBundle\Entity\Vote;

class WorkspaceController extends Controller
{
  public function viewAction($name)
  {
  	$em = $this->getDoctrine()->getManager();

  	// on récupère le WS selon le name passé en paramètres dans l'URL
  	$repo = $em->getRepository('BecowoCoreBundle:Workspace');
  	$ws = $repo->findOneByName($name);

    //On récupère les events liés à ce WS
    $repo = $em->getRepository('BecowoCoreBundle:Event');
    $listEvents = $repo->findBy(array('workspace' => $ws));


  	return $this->render('BecowoCoreBundle:Workspace:view.html.twig', array('ws' => $ws, 'listEvents' => $listEvents));
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