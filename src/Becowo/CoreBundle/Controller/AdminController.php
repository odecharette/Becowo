<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
  public function homeAction()
  {
  	return $this->render('BecowoCoreBundle:Admin:home.html.twig');
  }


}