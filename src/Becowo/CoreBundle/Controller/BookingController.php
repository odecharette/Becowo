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
    $WsService = $this->get('app.workspace');
    $bookings = $WsService->getBookingByMember($this->getUser());

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
    $session = $request->getSession();

    $WsHasOffice = $WsService->getWsHasOfficeById($id);
    $ws = $WsHasOffice->getWorkspace(); 
    $prices = $WsService->getPricesByWsHasOfficeId($id);
    $times = $WsService->getTimesByWorkspace($ws);
    $closedDates = $WsService->getClosedDatesByWorkspace($ws);
    $pictures = $WsService->getPicturesByWorkspace($ws->getName());
    $averageVote = $WsService->getAverageVoteByWorkspace($ws);
    $em = $this->getDoctrine()->getManager();

    if($session->get('booking') !== null)
    {
      // Il faut récupérer le booking via le repositiry et directement l'objet en session sinon le Update ne marche pas
      $booking = $WsService->getBookingByRef($session->get('booking')->getBookingRef());

    }else{
      $booking = new Booking();
      // Par défaut le booking est crée sur la prochaine date ouvert (selon samedi, dimanche, closeddates)
      $booking->setStartDate($WsService->getNextOpenDateByWorkspace($ws));
    }
    $bookingForm = $this->createForm(BookingType::class, $booking);
 
    if ($request->isMethod('POST') && $bookingForm->handleRequest($request)->isValid())
    {

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

    	$bookingPriceExclTax = $request->get('price-excl-tax');
      $bookingPriceInclTax = $request->get('price-incl-tax');
    	$bookingDurationDay = $request->get('booking-duration-day');
    	$bookingPeople = $request->get('booking-people');

    	$currentUser = $this->getUser();

    	$status = $WsService->getStatusById(1); // "Id 1 : En cours"

      $booking->setIsFirstBookFree(false);
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

    	
    	$em->persist($booking);
  	  $em->flush();

      
      $session->set('booking', $booking);

      return $this->redirectToRoute('becowo_core_paiement_call_bank');
    }


    return $this->render('Workspace/booking-form.html.twig', 
      array('booking' => $booking, 'bookingForm' => $bookingForm->createView(),'id' =>$id, 'WsHasOffice' => $WsHasOffice, 'ws' => $ws, 'prices' => $prices[0], 'times' => $times[0], 'closedDates' => $closedDates, 'pictures' => $pictures, 'averageVote' => $averageVote));
  }

  public function bookFreeAction($ws, Request $request)
  {
    $WsService = $this->get('app.workspace');
    $session = $request->getSession();

    $workspace = $WsService->getWorkspaceById($ws);
    $times = $WsService->getTimesByWorkspace($workspace);
    $closedDates = $WsService->getClosedDatesByWorkspace($workspace);
    $averageVote = $WsService->getAverageVoteByWorkspace($workspace);
    $em = $this->getDoctrine()->getManager();

    if($session->get('bookingFree') !== null)
    {
      // Il faut récupérer le booking via le repositiry et directement l'objet en session sinon le Update ne marche pas
      $booking = $WsService->getBookingByRef($session->get('bookingFree')->getBookingRef());

    }else{
      $booking = new Booking();
      // Par défaut le booking est crée sur la prochaine date ouvert (selon samedi, dimanche, closeddates)
      $booking->setStartDate($WsService->getNextOpenDateByWorkspace($workspace));
      $booking->setIsFirstBookFree(true);
    }
    $bookingForm = $this->createForm(BookingType::class, $booking);
 
    if ($request->isMethod('POST') && $bookingForm->handleRequest($request)->isValid())
    {
      //SAVE le booking en cours en BDD

      $startDate = $request->get('booking-calendar');
      $startDate = str_replace('/', '-', $startDate);

      $currentUser = $this->getUser();

      $status = $WsService->getStatusById(1); // "Id 1 : En cours"

      $booking->setMember($currentUser);
      $booking->setStatus($status);
      $booking->setNbPeople(1);
      $booking->setStartDate(New \DateTime($startDate));
      $booking->setEndDate(New \DateTime($startDate));
      $booking->setMessage($bookingForm->get('message')->getData());

      $em->persist($booking);
      $em->flush();
      
      $session->set('bookingFree', $booking);

      return $this->redirectToRoute('becowo_core_booking_free_validated', array(
        'bookRef' => $booking->getBookingRef(), 
        'id' => $ws));
    }


    return $this->render('Workspace/booking-free-form.html.twig', 
      array('booking' => $booking, 'bookingForm' => $bookingForm->createView(),'ws' => $workspace, 'times' => $times[0], 'closedDates' => $closedDates, 'averageVote' => $averageVote));
  }

    public function bookFreeValidatedAction($id, $bookRef)
    {
      $WsService = $this->get('app.workspace');
      $workspace = $WsService->getWorkspaceById($id);
      $booking = $WsService->getBookingByRef($bookRef);

      return $this->render('Workspace/booking-free-validated.html.twig', array('bookRef' => $bookRef, 'ws' => $workspace, 'booking' => $booking));
    }

  	public function validateAction($bookRef, Request $request)
  	{
  		$WsService = $this->get('app.workspace');
    	$booking = $WsService->getBookingByRef($bookRef);

      if($booking->getStatus()->getId() == 4 )
      {
        $msg = "ATTENTION, Réservation déjà validée !";
      }else
      {
      	$status = $WsService->getStatusById(4); // "Id 4 : Réservation validée"
      	$booking->setStatus($status);
      	$em = $this->getDoctrine()->getManager();
    		$em->persist($booking);
  		  $em->flush();

  		  //On envoi un mail au coworker pour l'informer que la résa est confirmée

        $emailService = $this->get('app.email');
        $emailTemplate = "Coworker-ResaValidee";
        $emailParams = array('booking' => $booking);
        $emailTag = "Coworker - Réservation validée";
        $to = $booking->getMember()->getEmail();
        $subject = "Becowo - Réservation N°" . $bookRef . " validée";

        $emailService->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);

        $msg = "Réservation validée, merci !";
      }

		return $this->render('Booking/validated.html.twig', array('msg' => $msg));
  	}

  	public function refuseAction($bookRef, Request $request)
  	{
  		$WsService = $this->get('app.workspace');
    	$booking = $WsService->getBookingByRef($bookRef);

      if($booking->getStatus()->getId() == 5 )
      {
        $msg = "ATTENTION, Réservation déjà refusée !";
      }elseif($booking->getStatus()->getId() == 4 )
      {
        $msg = "ATTENTION, Cette réservation a déjà été validée. Merci de contacter Becowo : contact@becowo.com";
      }else
      {
    	  $status = $WsService->getStatusById(5); // "Id 5 : Réservation refusée"
      	$booking->setStatus($status);
      	$em = $this->getDoctrine()->getManager();
  		  $em->persist($booking);
		    $em->flush();

		    //On envoi un mail au coworker pour l'informer que la résa est refusée
        $emailService = $this->get('app.email');
        $emailTemplate = "Coworker-ResaRefusee";
        $emailParams = array('booking' => $booking);
        $emailTag = "Coworker - Réservation refusée";
        $to = $booking->getMember()->getEmail();
        $subject = "Becowo - Réservation N°" . $bookRef . " refusée";

        $emailService->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);

      	//Puis on envoi un mail à l'admin de Becowo pour procéder au remboursement
        $emailService = $this->get('app.email');
        $emailTemplate = "Admin-Rembourser";
        $emailParams = array('booking' => $booking);
        $emailTag = "Admin - Rembourser réservation";
        $to = "contact@becowo.com";
        $subject = "Becowo - Rembourser réservation N°" . $bookRef;

        $emailService->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);

        $msg = "Réservation refusée, merci.";
      }

		return $this->render('Booking/refused.html.twig', array('msg' => $msg));
  	}

}
