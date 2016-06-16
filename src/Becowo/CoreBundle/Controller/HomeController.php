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

    //On récupère les pictures liées à chaque WS
    $picturesByWs = array();
    $repo = $em->getRepository('BecowoCoreBundle:Picture');
    foreach ($workspaces as $ws) {
      $pictures = $repo->findByWsNoLogo($ws->getName());
      $picturesByWs[$ws->getName()] = $pictures;
    }

    // On récupère les offices et leur quantité
    $officesByWS = array();
    $repo = $em->getRepository('BecowoCoreBundle:WorkspaceHasOffice');
    foreach ($workspaces as $ws) {
      $offices = $repo->findBy(array('workspace' => $ws));
      $officesByWS[$ws->getName()] = $offices;
    }

	  // WS coup de coeur  	
  	$repo = $em->getRepository('BecowoCoreBundle:WorkspaceFavorite');
  	$workspaceFavorite = $repo->findOneBy(array(), array('createdOn' => 'desc'));

  	// Les x derniers membres inscrits et actifs
  	$repo = $em->getRepository('BecowoMemberBundle:Member');
  	$members = $repo->findNewMembers(5);

    // Construction du GeoJson pour la MapBox

    $geojson = array( 'type' => 'FeatureCollection', 'features' => array());

    foreach ($workspaces as $w) {
      $feature = array(
        'id' => $w->getId(),
        'type' => 'Feature', 
        'geometry' => array(
            'type' => 'Point',
            'coordinates' => array($w->getLongitude(), $w->getLatitude())
        ),
        'properties' => array(
            'name' => $w->getName(),
            'street' => $w->getStreet(),
            'city' => $w->getCity()
            )
        );
    array_push($geojson['features'], $feature);
    }

  $workspacesInJson = json_encode($geojson);

  	return $this->render('Home/home.html.twig', array(
  		'workspaces' => $workspaces, 
  		'members' => $members, 
  		'workspaceFavorite' => $workspaceFavorite,
      'picturesByWs' => $picturesByWs,
      'officesByWS' => $officesByWS,
      'workspacesInJson' => $workspacesInJson));
  }



}