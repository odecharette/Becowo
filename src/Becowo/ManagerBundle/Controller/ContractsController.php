<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContractsController extends Controller
{
  public function viewAction()
  {
  	return $this->render('Manager/contracts.html.twig');
  }


}