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

  	// Tous les members
  	//TO DO : récupérer que les 5 derniers membre inscrits
  	$repo = $em->getRepository('BecowoCoreBundle:Member');
  	$members = $repo->findAll();

  	//TO DO : récupérer que les 3 derniers espaces inscrits

	// WS coup de coeur  	
  	$repo = $em->getRepository('BecowoCoreBundle:WorkspaceFavorite');
  	$workspaceFavorite = $repo->findOneBy(array(), array('createdOn' => 'desc'));

  	return $this->render('BecowoCoreBundle:Home:home.html.twig', array(
  		'workspaces' => $workspaces, 
  		'members' => $members, 
  		'workspaceFavorite' => $workspaceFavorite));
  }


}