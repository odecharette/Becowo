<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Becowo\CoreBundle\Services\Workspace;

class HomeController extends Controller
{
  public function homeAction()
  {
  	$em = $this->getDoctrine()->getManager();  // A supprimer qd tt remplacé par service

  	// Tous les workspaces
  	// $repo = $em->getRepository('BecowoCoreBundle:Workspace');
  	// $workspaces = $repo->findActiveWorkspaces();

    // Tous les workspaces (via service)
    $WsService = $this->get('app.workspace');
    $workspaces = $WsService->getActiveWorkspaces(); 

    //On récupère les pictures liées à chaque WS
    // $picturesByWs = array();
    // $repo = $em->getRepository('BecowoCoreBundle:Picture');
    // foreach ($workspaces as $ws) {
    //   $pictures = $repo->findByWsNoLogo($ws->getName());
    //   $picturesByWs[$ws->getName()] = $pictures;
    // }

    $picturesByWs = $WsService->getPicturesByWorkspaces($workspaces);

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
    // marker-symbol : https://www.mapbox.com/maki-icons/

    $geojson = array( 'type' => 'FeatureCollection', 'features' => array());

    foreach ($workspaces as $w) {
      $feature = array(
        'type' => 'Feature', 
        'geometry' => array(
            'type' => 'Point',
            'coordinates' => array($w->getLongitude(), $w->getLatitude())
        ),
        'properties' => array(
            'type' => 'workspace',
            'id' => $w->getId(),
            'name' => $w->getName(),
            'street' => $w->getStreet(),
            'city' => $w->getCity(),
            'marker-symbol' => 'water',
            'marker-color' => '#3bb2d0'
            )
        );
    array_push($geojson['features'], $feature);
    }
    

    // Ajout des POI

    $repo = $em->getRepository('BecowoCoreBundle:Poi');  
    $poi = $repo->findPoiWithCategory();

    foreach ($poi as $poi) {

      $feature = array(
          'type' => 'Feature', 
          'geometry' => array(
              'type' => 'Point',
              'coordinates' => array($poi->getLongitude(), $poi->getLatitude())
          ),
          'properties' => array(
              'type' => $poi->getPoiCategory()->getName(),
              'id' => $poi->getId(),
              'name' => str_replace("'"," ",$poi->getName()), // enleve les apostrophes
              'marker-symbol' => $poi->getMarkerSymbol(),
              'marker-color' => '#FA9EEE'
              )
          );
      array_push($geojson['features'], $feature);
    }

    // $feature = array(
    //     'type' => 'Feature', 
    //     'geometry' => array(
    //         'type' => 'Point',
    //         'coordinates' => array(3.504639, 47.338823)
    //     ),
    //     'properties' => array(
    //         'type' => 'poi2',
    //         'id' => $w->getId(),
    //         'name' => 'La roche',
    //         'marker-symbol' => 'bus'
    //         )
    //     );
    // array_push($geojson['features'], $feature);

    // fin test POI

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