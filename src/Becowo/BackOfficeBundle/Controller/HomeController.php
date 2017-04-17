<?php

namespace Becowo\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
  public function homeAction(Request $request)
  {

    return $this->render('BackOffice/home.html.twig');
  }


}
