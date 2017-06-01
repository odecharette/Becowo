<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
  public function homeAction(Request $request)
  {
    return $this->render('Home/home.html.twig');
  }

  public function searchAction(Request $request)
  {
    return $this->render('Search/searchPage.html.twig');
  }

}
