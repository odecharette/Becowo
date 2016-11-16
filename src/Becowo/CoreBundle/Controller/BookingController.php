<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BookingController extends Controller
{
  public function myReservationsAction(Request $request)
  {
    $bookings = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Booking')->findBy(
        array('member' => $this->getUser() ),
        array('createdOn' => 'DESC'));

    return $this->render('Booking/myReservations.html.twig', array('bookings' => $bookings));
  }

  public function bookFormAction($name, Request $request)
  {
  	$WsService = $this->get('app.workspace');
  	$ws = $WsService->getWorkspaceByName($name);
  	$listOffices = $WsService->getOfficesByWorkspace($ws);
  	$prices = $WsService->getPricesByWorkspace($ws);
  	$times = $WsService->getTimesByWorkspace($ws);
  	$closedDates = $WsService->getClosedDatesByWorkspace($ws);

  	if ($request->isMethod('POST'))
  	{
  		// TO DO : vérifier ici que le formulaire de résa est complet/valide

  		return $this->redirectToRoute('becowo_core_booking_form', array('name' => $request->get('name')));
  		//return $this->render('Workspace/book-validated.html.twig');
  	}
  	return $this->render('Workspace/book3.html.twig', array('listOffices' => $listOffices, 'prices' => $prices, 'ws' => $ws, 'times' => $times, 'closedDates' => $closedDates));
  }

  public function bookAction($name, Request $request)
  {
  	//SAVE le booking en cours en BDD
  	dump($request);

  	$WsService = $this->get('app.workspace');

    $ws = $WsService->getWorkspaceByName($name);

  	$office = explode("*", $request->get('office'));
  	$officeName = $office[0];
  	$officeType = $office[1];

  	$officeObj = $WsService->getOfficeByName($officeType);
  	$officeOfWs = $WsService->getOfficeOfWorkspaceByWsOfficeName($ws, $officeObj, $officeName);
  	$bookingDuration = $request->get('booking-duration');
  	$bookingCalendar = $request->get('booking-calendar');
  	$bookingDurationDay = $request->get('booking-duration-day');

  	$currentUser = $this->getUser();

  	return $this->render('Workspace/book-validated.html.twig');


  }
}
