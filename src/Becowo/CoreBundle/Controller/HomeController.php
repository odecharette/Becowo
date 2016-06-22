<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Becowo\CoreBundle\Services\Workspace;

class HomeController extends Controller
{
  public function homeAction()
  {
  	$em = $this->getDoctrine()->getManager();  // A supprimer qd tt remplacé par service

    // Récupération du service workspace
    $WsService = $this->get('app.workspace');

    // Tous les WS actifs
    $workspaces = $WsService->getActiveWorkspaces(); 
    // Les photos par WS sauf logo
    $picturesByWs = $WsService->getPicturesByWorkspaces($workspaces);
    // On récupère les offices et leur quantité
    $officesByWS = $WsService->getOfficesByWorkspaces($workspaces);
	  // WS coup de coeur
    $workspaceFavorite = $WsService->getFavoriteWorkspace();


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