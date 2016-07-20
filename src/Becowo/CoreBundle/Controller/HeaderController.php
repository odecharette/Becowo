<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class HeaderController extends Controller
{
  
  public function DeclarerEspaceAction()
  {
    return $this->render('Footer/declarer-espace.html.twig');
  }
}
