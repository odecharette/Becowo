<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
  public function viewAction()
  {
  	$WsService = $this->get('app.workspace');

  	$NbBookings = count($WsService->getReservationsByWorkspace($this->getUser()->getWorkspace()));

  	return $this->render('Manager/dashboard.html.twig', array('NbBookings' => $NbBookings));
  }


}