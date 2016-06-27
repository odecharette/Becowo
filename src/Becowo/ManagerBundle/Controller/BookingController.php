<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookingController extends Controller
{
  public function viewAction()
  {
  	$WsService = $this->get('app.workspace');

  	$bookings = $WsService->getReservationsByWorkspace($this->getUser()->getWorkspace());

  	return $this->render('Manager/booking.html.twig', array('bookings' => $bookings));
  }


}