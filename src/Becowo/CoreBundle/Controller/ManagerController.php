<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManagerController extends Controller
{
  public function homeAction()
  {
  	return $this->render('Manager/home.html.twig');
  }


}