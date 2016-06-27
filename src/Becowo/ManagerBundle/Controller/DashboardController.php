<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
  public function viewAction()
  {
  	return $this->render('Manager/dashboard.html.twig');
  }


}