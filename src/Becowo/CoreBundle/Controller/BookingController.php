<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Booking;
use Becowo\CoreBundle\Entity\Status;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Becowo\CoreBundle\Form\Type\BookingType;

class BookingController extends Controller
{
  public function myReservationsAction(Request $request)
  {
    $bookings = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Booking')->findBy(
        array('member' => $this->getUser() ),
        array('createdOn' => 'DESC'));

    return $this->render('Booking/myReservations.html.twig', array('bookings' => $bookings));
  }

  public function bookingListAction($name, Request $request)
  {
  	$WsService = $this->get('app.workspace');
  	$ws = $WsService->getWorkspaceByName($name);
    $pricesAndOffices = $WsService->getPricesByWorkspace($ws);

  	return $this->render('Workspace/booking-list.html.twig', array(
        'pricesAndOffices' => $pricesAndOffices,'ws' => $ws));
  }

  public function bookAction($id, Request $request)
  {
    $WsService = $this->get('app.workspace');

    $booking = new Booking();
    $bookingForm = $this->createForm(BookingType::class, $booking);
 
    $WsHasOffice = $WsService->getWsHasOfficeById($id);
    $ws = $WsHasOffice->getWorkspace(); 
    $prices = $WsService->getPricesByWsHasOfficeId($id);
    $times = $WsService->getTimesByWorkspace($ws);
    $closedDates = $WsService->getClosedDatesByWorkspace($ws);
    $pictures = $WsService->getPicturesByWorkspace($ws->getName());
    $averageVote = $WsService->getAverageVoteByWorkspace($ws);

    if ($request->isMethod('POST') && $bookingForm->handleRequest($request)->isValid())
    {
dump($request);
      //SAVE le booking en cours en BDD

    	$bookingDuration = $request->get('booking-duration');

      $startDate = $request->get('booking-calendar');
      $endDate = $request->get('dateEnd');
      $startDate = str_replace('/', '-', $startDate);
      $endDate = str_replace('/', '-', $endDate);


    	$bookingTimeSlider = explode(",",$request->get('booking-time-slider'));
    	isset($bookingTimeSlider[0]) ? $startTime = floor($bookingTimeSlider[0] / 60) . ':' . ($bookingTimeSlider[0] % 60) : $startTime = "00:00";
    	isset($bookingTimeSlider[1]) ? $endTime = floor($bookingTimeSlider[1] / 60) . ':' . ($bookingTimeSlider[1] % 60) : $endTime = "00:00";

    	$startDate = $startDate . 'T' . $startTime;
    	$endDate = $endDate . 'T' . $endTime;

      dump($startDate);
      dump($endDate);
    	$bookingPriceExclTax = $request->get('price-excl-tax');
      $bookingPriceInclTax = $request->get('price-incl-tax');
    	$bookingDurationDay = $request->get('booking-duration-day');
    	$bookingPeople = $request->get('booking-people');

    	$currentUser = $this->getUser();

    	$status = $WsService->getStatusById(1); // "Id 1 : En cours"

    	$booking->setWorkspaceHasOffice($WsHasOffice);
    	$booking->setMember($currentUser);
    	$booking->setStatus($status);
    	$booking->setDuration($bookingDuration);
    	$booking->setStartDate(New \DateTime($startDate));
      $booking->setEndDate(New \DateTime($endDate));
    	$booking->setDurationDay($bookingDurationDay);
    	$booking->setNbPeople($bookingPeople);
    	$booking->setPriceInclTax($bookingPriceInclTax);
    	$booking->setPriceExclTax($bookingPriceExclTax);
      $booking->setMessage($bookingForm->get('message')->getData());
    	// TO DO : déterminer si isFirstBook

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($booking);
  	  $em->flush();

      $session = $request->getSession();
      $session->set('booking', $booking);

      return $this->redirectToRoute('becowo_core_paiement_call_bank');
      // return  $this->forward("BecowoCoreBundle:Paiement:callBank");
      
// Pour voir l'url complète envoyée à la banque : dump($request->getContent());
//return new RedirectResponse('https://preprod-tpeweb.e-transactions.fr/cgi/MYchoix_pagepaiement.cgi', Response::HTTP_TEMPORARY_REDIRECT);
    }

    return $this->render('Workspace/booking-form.html.twig', 
      array('bookingForm' => $bookingForm->createView(),'id' =>$id, 'WsHasOffice' => $WsHasOffice, 'ws' => $ws, 'prices' => $prices[0], 'times' => $times[0], 'closedDates' => $closedDates, 'pictures' => $pictures, 'averageVote' => $averageVote));
  }

  	public function validateAction($bookRef, Request $request)
  	{
  		$WsService = $this->get('app.workspace');
    	$booking = $WsService->getBookingByRef($bookRef);
    	$status = $WsService->getStatusById(4); // "Id 4 : Réservation validée"
      	$booking->setStatus($status);
      	$em = $this->getDoctrine()->getManager();
  		$em->persist($booking);
		$em->flush();

		//On envoi un mail au coworker pour l'informer que la résa est confirmée
      	$message = \Swift_Message::newInstance()
        ->setSubject("Becowo - Réservation N°" . $bookRef . " validée")
        ->setFrom('contact@becowo.com')
        ->setTo($booking->getMember()->getEmail())
        ->setBody(
            $this->renderView(
                'CommonViews/Mail/Coworker-ResaValidee.html.twig',
                array('booking' => $booking)
            ));

      	$this->get('mailer')->send($message);

		return $this->render('Booking/validated.html.twig');
  	}

  	public function refuseAction($bookRef, Request $request)
  	{
  		$WsService = $this->get('app.workspace');
    	$booking = $WsService->getBookingByRef($bookRef);
    	$status = $WsService->getStatusById(5); // "Id 5 : Réservation refusée"
      	$booking->setStatus($status);
      	$em = $this->getDoctrine()->getManager();
  		$em->persist($booking);
		$em->flush();

		//On envoi un mail au coworker pour l'informer que la résa est refusée
      	$message = \Swift_Message::newInstance()
        ->setSubject("Becowo - Réservation N°" . $bookRef . " refusée")
        ->setFrom('contact@becowo.com')
        ->setTo($booking->getMember()->getEmail())
        ->setBody(
            $this->renderView(
                'CommonViews/Mail/Coworker-ResaRefusee.html.twig',
                array('booking' => $booking)
            ));

      	$this->get('mailer')->send($message);

      	//Puis on envoi un mail à l'admin de Becowo pour procéder au remboursement
      	$message = \Swift_Message::newInstance()
        ->setSubject("Becowo - Rembourser réservation N°" . $bookRef)
        ->setFrom('contact@becowo.com')
        ->setTo('webmaster@becowo.com')
        ->setBody(
            $this->renderView(
                'CommonViews/Mail/Admin-Rembourser.html.twig',
                array('booking' => $booking)
            ));

      	$this->get('mailer')->send($message);

		return $this->render('Booking/refused.html.twig');
  	}

}
