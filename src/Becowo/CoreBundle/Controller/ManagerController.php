<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ManagerController extends Controller
{
  public function homeAction()
  {
  	return $this->render('BecowoCoreBundle:Manager:home.html.twig');
  }


}