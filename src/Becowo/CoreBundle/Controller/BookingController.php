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

  	$WsService = $this->get('app.workspace');

    $ws = $WsService->getWorkspaceByName($name);

  	$office = explode("*", $request->get('office'));
  	$officeName = $office[0];
  	$officeType = $office[1];



  	$officeObj = $WsService->getOfficeByName($officeType);
  	$officeOfWs = $WsService->getOfficeOfWorkspaceByWsOfficeName($ws, $officeObj, $officeName);

  	$bookingDuration = $request->get('booking-duration');

  	// Pour les dates, on récupère séparement les dates et heure, puis on convertit puis on concatene le tout

  	$bookingCalendar = explode(" - ",$request->get('booking-calendar'));
  	isset($bookingCalendar[0]) ? $startDate = $bookingCalendar[0] : $startDate = null;
  	isset($bookingCalendar[1]) ? $endDate = $bookingCalendar[1] : $endDate = $startDate;
  	$startDate = str_replace('/', '-', $startDate);
  	$endDate = str_replace('/', '-', $endDate);

  	$bookingTimeSlider = explode(",",$request->get('booking-time-slider'));
  	isset($bookingTimeSlider[0]) ? $startTime = floor($bookingTimeSlider[0] / 60) . ':' . ($bookingTimeSlider[0] % 60) : $startTime = "00:00";
  	isset($bookingTimeSlider[1]) ? $endTime = floor($bookingTimeSlider[1] / 60) . ':' . ($bookingTimeSlider[1] % 60) : $endTime = "00:00";

  	$startDate = $startDate . 'T' . $startTime;
  	$endDate = $endDate . 'T' . $endTime;

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
  	$booking->setDurationDay($bookingDurationDay);
  	$booking->setNbPeople($bookingPeople);
  	$booking->setPriceInclTax($bookingPriceInclTax);
  	$booking->setPriceExclTax($bookingPriceInclTax * (1 - floatval($this->container->getParameter('tva')/100)));
  	// TO DO : déterminer si isFirstBook

  	$em = $this->getDoctrine()->getManager();
  	$em->persist($booking);
	$em->flush();

	$priceToPay = $bookingPriceInclTax * 100; // il faut envoyer le prix en cts

	// Ce controller est appelé en AJAX dans main.js, donc le résult s'affiche dans une DIV dans la page du WS
  	return $this->render('Workspace/book-validated.html.twig', array('priceToPay' =>$priceToPay, 'bookingRef' => $booking->getBookingRef()));
  }

  	public function validateAction($bookRef, Request $request)
  	{
  		// TO DO : valider résa en BDD et informer coworker
  	}

  	public function refuseAction($bookRef, Request $request)
  	{
  		// TO DO : refuser résa en BDD et informer coworker
  	}

}
