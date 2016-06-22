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

    // Récupération du service Membre
    $WsService = $this->get('app.member');

  	// Les x derniers membres inscrits et actifs
    $members = $WsService->getLastActiveMembers(5);
   
    // Récupération du service Map
    $WsService = $this->get('app.map');

    $mapGeoJson = $WsService->prepareGeoJson();
    $mapGeoJson = $WsService->addWorkspaces($workspaces, $mapGeoJson);
    $mapGeoJson = $WsService->addPoi($mapGeoJson);
    $mapGeoJson = $WsService->createGeoJson($mapGeoJson);

  	return $this->render('Home/home.html.twig', array(
  		'workspaces' => $workspaces, 
  		'members' => $members, 
  		'workspaceFavorite' => $workspaceFavorite,
      'picturesByWs' => $picturesByWs,
      'officesByWS' => $officesByWS,
      'mapGeoJson' => $mapGeoJson));
  }



}