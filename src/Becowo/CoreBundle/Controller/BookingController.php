<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Booking;
use Becowo\CoreBundle\Entity\Status;

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
  	$bookingCalendar = explode(" - ",$request->get('booking-calendar'));
  	isset($bookingCalendar[0]) ? $startDate = $bookingCalendar[0] : $startDate = null;
  	isset($bookingCalendar[1]) ? $endDate = $bookingCalendar[1] : $endDate = $startDate;
  	$startDate = str_replace('/', '-', $startDate);
  	$endDate = str_replace('/', '-', $endDate);

  	// TO DO convertir milliseconds en time

  	// $bookingTimeSlider = explode(",",$request->get('booking-time-slider'));
  	// isset($bookingTimeSlider[0]) ? $startDate = $startDate . $bookingTimeSlider[0];
  	// isset($bookingTimeSlider[1]) ? $endTime = $bookingTimeSlider[1];


  	$bookingPriceInclTax = $request->get('booking-price-incl-tax');
  	$bookingDurationDay = $request->get('booking-duration-day');
  	$bookingPeople = $request->get('booking-people');

  	$currentUser = $this->getUser();

  	$status = $WsService->getStatusById(1); // "Id 1 : En cours"

  	$booking = New Booking();
  	$booking->setWorkspaceHasOffice($officeOfWs);
  	$booking->setMember($currentUser);
  	$booking->setStatus($status);
  	$booking->setDuration($bookingDuration);
  	$booking->setStartDate(New \DateTime($startDate));
  	$booking->setEndDate(New \DateTime($endDate));
  	// TO DO $booking->setStartTime(New \DateTime("05:14:12"));
  	// TO DO $booking->setEndTime($endTime);
  	$booking->setDurationDay($bookingDurationDay);
  	$booking->setNbPeople($bookingPeople);
  	$booking->setPriceInclTax($bookingPriceInclTax);
  	// TO DO : déterminer si isFirstBook

  	$em = $this->getDoctrine()->getManager();
  	$em->persist($booking);
	$em->flush();

  	return $this->render('Workspace/book-validated.html.twig');


  }
}
