<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
  public function testAction()
  {
  	
  	return $this->render('Test/test.html.twig');
  }



}