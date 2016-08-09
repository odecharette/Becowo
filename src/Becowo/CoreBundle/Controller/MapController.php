<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MapController extends Controller
{
  public function viewAction(Request $request)
  {

    return $this->render('Home/map.html.twig');
  }
}
