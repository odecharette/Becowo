<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Becowo\CoreBundle\Entity\Workspace;
use Becowo\MemberBundle\Entity\Member;

class HomeController extends Controller
{
  public function homeAction()
  {
  	$em = $this->getDoctrine()->getManager();

  	// Tous les workspaces
  	$repo = $em->getRepository('BecowoCoreBundle:Workspace');
  	$workspaces = $repo->findActiveWorkspaces();

    // Les x derniers WS crées et actifs
    $newWorkspaces = $repo->findNewWorkspaces(3);

    $picturesByWs = array();
    foreach ($workspaces as $ws) {
      //On récupère les pictures liées à chaque WS
      $repo = $em->getRepository('BecowoCoreBundle:Picture');
      $pictures = $repo->findBy(array('workspace' => $ws));

      $picturesByWs[$ws->getName()] = $pictures;
    }

	// WS coup de coeur  	
  	$repo = $em->getRepository('BecowoCoreBundle:WorkspaceFavorite');
  	$workspaceFavorite = $repo->findOneBy(array(), array('createdOn' => 'desc'));

  	// Les x derniers membres inscrits et actifs
  	$repo = $em->getRepository('BecowoMemberBundle:Member');
  	$members = $repo->findNewMembers(5);

  	return $this->render('BecowoCoreBundle:Home:home.html.twig', array(
  		'workspaces' => $workspaces, 
  		'members' => $members, 
  		'workspaceFavorite' => $workspaceFavorite,
  		'newWorkspaces' => $newWorkspaces,
      'picturesByWs' => $picturesByWs));
  }

}