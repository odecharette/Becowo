<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
  public function viewAction()
  {

  	$managed_WS = $this->getUser()->getWorkspace();
  	
  	return $this->render('Manager/workspace_profile.html.twig', array('managed_WS' => $managed_WS));
  }


}