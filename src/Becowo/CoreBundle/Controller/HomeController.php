<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    foreach ($newWorkspaces as $ws) {
      //On récupère la picture favorite liée à chaque WS
      $repo = $em->getRepository('BecowoCoreBundle:Picture');
      $picture = $repo->findByWsFavorite($ws->getName());

      $pictureFavoriteByWs[$ws->getName()] = $picture;
    }

    $picturesByWs = array();
    foreach ($workspaces as $ws) {
      //On récupère les pictures liées à chaque WS
      $repo = $em->getRepository('BecowoCoreBundle:Picture');
      $pictures = $repo->findByWsNoLogo($ws->getName());

      $picturesByWs[$ws->getName()] = $pictures;
    }

	// WS coup de coeur  	
  	$repo = $em->getRepository('BecowoCoreBundle:WorkspaceFavorite');
  	$workspaceFavorite = $repo->findOneBy(array(), array('createdOn' => 'desc'));

  	// Les x derniers membres inscrits et actifs
  	$repo = $em->getRepository('BecowoMemberBundle:Member');
  	$members = $repo->findNewMembers(5);

  	return $this->render('Home/home.html.twig', array(
  		'workspaces' => $workspaces, 
  		'members' => $members, 
  		'workspaceFavorite' => $workspaceFavorite,
  		'newWorkspaces' => $newWorkspaces,
      'picturesByWs' => $picturesByWs,
      'pictureFavoriteByWs' => $pictureFavoriteByWs));
  }

}