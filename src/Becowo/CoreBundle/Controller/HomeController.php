<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
  public function homeAction()
  {
    $WsService = $this->get('app.workspace');
    $workspaces = $WsService->getActiveWorkspaces(); 
    $picturesByWs = $WsService->getPicturesByWorkspaces($workspaces);
    $officesByWS = $WsService->getOfficesByWorkspaces($workspaces);
    $workspaceFavorite = $WsService->getFavoriteWorkspace();

    $WsService = $this->get('app.member');
    $members = $WsService->getLastActiveMembers(5);

    $WsService = $this->get('app.comment');
    $comments = $WsService->getLastCommentsAndAuthor(3);
   
    // $WsService = $this->get('app.map');
    // $mapGeoJson = $WsService->getWsAndPoiInGeoJson($workspaces);

    //////////////// TO DO IMPORTANT
    // Pour le moment, le XML de la map est généré dans MapController
    // Désactiver le service map, la variable mapGeoJson
    // Trouver un moyen de générer le XML directement (pour le moment, je lance le controller, récupère le contenu du dump et colle dans locations.xml)
    // delete route extract et map

  	return $this->render('Home/home.html.twig', array(
  		'workspaces' => $workspaces, 
  		'members' => $members, 
  		'workspaceFavorite' => $workspaceFavorite,
      'picturesByWs' => $picturesByWs,
      'officesByWS' => $officesByWS,
      'comments' => $comments
      // ,      'mapGeoJson' => $mapGeoJson
      ));
  }

}
