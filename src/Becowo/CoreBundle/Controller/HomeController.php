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
   
    $WsService = $this->get('app.map');
    $mapGeoJson = $WsService->getWsAndPoiInGeoJson($workspaces);

    // Test Algolia
    // $this->get('algolia.indexer')->rawSearch('Workspace', 'mutualab');
    $result = $this->get('algolia.indexer')->search(
    $this->getDoctrine()->getManager(),
    'BecowoCoreBundle:Workspace',
    'mutualab'
    );

  	return $this->render('Home/home.html.twig', array(
  		'workspaces' => $workspaces, 
  		'members' => $members, 
  		'workspaceFavorite' => $workspaceFavorite,
      'picturesByWs' => $picturesByWs,
      'officesByWS' => $officesByWS,
      'mapGeoJson' => $mapGeoJson,
      'result' => $result));
  }
}
