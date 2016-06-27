<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BillsController extends Controller
{
  public function viewAction()
  {
  	return $this->render('Manager/bills.html.twig');
  }


}