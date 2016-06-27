<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
  public function viewAction()
  {
  	$WsService = $this->get('app.workspace');

  	$u = $this->getUser()->getWorkspace();
    //$ws = $WsService->getWorkspaceByName($name);
  	return $this->render('Manager/workspace_profile.html.twig', array('u' => $u));
  }


}