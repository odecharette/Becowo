<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Booking;
use Becowo\CoreBundle\Entity\BookingHasPartnerOffer;
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
    $nbPartnerOffers = $WsService->getCountPartnerOffersByWorkspace($ws);

  	return $this->render('Workspace/booking-list.html.twig', array(
        'pricesAndOffices' => $pricesAndOffices,
        'ws' => $ws,
        'nbPartnerOffers' => $nbPartnerOffers));
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
    $partnerOffers = $WsService->getPartnerOffersByWorkspace($ws);

    if(isset($session->get('basket')['booking']))
    {
      // Il faut récupérer le booking via le repositiry et directement l'objet en session sinon le Update ne marche pas
      $booking = $WsService->getBookingByRef($session->get('basket')['booking']->getBookingRef());

      if(isset($session->get('basket')['partnerOffers']))
      {
        $bookedPartnerOffers = $session->get('basket')['partnerOffers'];
      }else
      {
        $bookedPartnerOffers = array();
      }
    }else{
      $booking = new Booking();
      // Par défaut le booking est crée sur la prochaine date ouvert (selon samedi, dimanche, closeddates)
      $booking->setStartDate($WsService->getNextOpenDateByWorkspace($ws));
      $bookedPartnerOffers = array();
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

      // On reste les prestation liées au booking (si user fait un retour arrière et recommence)
      $temp = $WsService->getBookingHasPartnerOfferByBooking($booking);
      foreach ($temp as $t) {
        $em->remove($t);
      }
      // On sauvegarde les prestations liées au booking

      $tabListPartnerOffersToReserve = explode(',',$request->get('listPartnerOffersToReserve'));
      $bookingPartnerOffers = array();
      foreach ($tabListPartnerOffersToReserve as $offer) {
        if($offer != "")
        {
          $bookingHasPartnerOffer = new BookingHasPartnerOffer();
          $bookingHasPartnerOffer->setBooking($booking);
          $bookingHasPartnerOffer->setPartnerOffer($WsService->getPartnerOffersByName($offer));
          $bookingHasPartnerOffer->setQuantity($request->get('prestaNbPersToReserve'));
          $em->persist($bookingHasPartnerOffer);
          array_push($bookingPartnerOffers, $bookingHasPartnerOffer);
        }
      }


  	  $em->flush();

      // On met le panier en cours en session
      $basket = array();
      $basket['booking'] = $booking;
      $basket['partnerOffers'] = $bookingPartnerOffers;
      $session->set('basket', $basket);

      return $this->redirectToRoute('becowo_core_paiement_call_bank');
    }


    return $this->render('Workspace/booking-form.html.twig', array(
      'booking' => $booking, 
      'bookingForm' => $bookingForm->createView(),
      'id' =>$id, 
      'WsHasOffice' => $WsHasOffice, 
      'ws' => $ws, 
      'prices' => $prices[0], 
      'times' => $times[0], 
      'closedDates' => $closedDates, 
      'pictures' => $pictures, 
      'averageVote' => $averageVote,
      'partnerOffers' => $partnerOffers,
      'bookedPartnerOffers' => $bookedPartnerOffers));
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
