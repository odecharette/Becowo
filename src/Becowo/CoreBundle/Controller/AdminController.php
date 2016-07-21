<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
  public function homeAction()
  {
  	return $this->render('Admin/home.html.twig');
  }


}
