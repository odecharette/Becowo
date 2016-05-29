<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Becowo\CoreBundle\Entity\Workspace;

class HomeController extends Controller
{
  public function homeAction()
  {
  	$em = $this->getDoctrine()->getManager();

  	// Touts les workspaces
  	$repo = $em->getRepository('BecowoCoreBundle:Workspace');
  	$workspaces = $repo->findActiveWorkspaces();

  	// Les x derniers WS crées et actifs
  	$newWorkspaces = $repo->findNewWorkspaces(3);

	// WS coup de coeur  	
  	$repo = $em->getRepository('BecowoCoreBundle:WorkspaceFavorite');
  	$workspaceFavorite = $repo->findOneBy(array(), array('createdOn' => 'desc'));

  	// Les x derniers membres inscrits et actifs
  	$repo = $em->getRepository('BecowoCoreBundle:Member');
  	$members = $repo->findNewMembers(5);

  	return $this->render('BecowoCoreBundle:Home:home.html.twig', array(
  		'workspaces' => $workspaces, 
  		'members' => $members, 
  		'workspaceFavorite' => $workspaceFavorite,
  		'newWorkspaces' => $newWorkspaces));
  }


}