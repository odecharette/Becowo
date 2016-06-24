<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
  public function viewAction()
  {
  	return $this->render('Manager/workspace_profile.html.twig');
  }


}