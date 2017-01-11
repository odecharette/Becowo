<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
  public function homeAction()
  {
    /*
    $WsService = $this->get('app.workspace');
    $workspaces = $WsService->getActiveWorkspaces(); 
    $picturesByWs = $WsService->getPicturesByWorkspaces($workspaces);
    $officesByWS = $WsService->getOfficesByWorkspaces($workspaces);
    $workspaceFavorite = $WsService->getFavoriteWorkspace();

  	return $this->render('Home/home.html.twig', array(
  		'workspaces' => $workspaces, 
  		'workspaceFavorite' => $workspaceFavorite,
      'picturesByWs' => $picturesByWs,
      'officesByWS' => $officesByWS
      ));
    */
      return $this->render('Home/home.html.twig');
  }

  public function communityAction()
  {
    $MemberService = $this->get('app.member');
    $members = $MemberService->getAllActiveMembers();
    
    return $this->render('Home/community.html.twig', array('members' => $members));
  }

}
