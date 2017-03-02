<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommunityController extends Controller
{
  public function networkAction(Request $request)
  {

    return $this->render('Manager/community/network.html.twig');
  }

  
}
