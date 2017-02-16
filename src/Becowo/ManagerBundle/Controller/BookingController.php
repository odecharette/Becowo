<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Booking;
use Becowo\CoreBundle\Form\Type\BookingManagerType;

class BookingController extends Controller
{
  public function viewAction()
  {
  	$WsService = $this->get('app.workspace');

  	$bookings = $WsService->getReservationsByWorkspace($this->getUser()->getWorkspace());

  	return $this->render('Manager/booking/booking.html.twig', array('bookings' => $bookings));
  }

  public function addAction(Request $request)
  {
  	$booking = new Booking();
  	$booking->setMember(null); // booking interne, pas de member
  	$form = $this->get('form.factory')->create(BookingManagerType::class, $booking, array('idWs' => $this->getUser()->getWorkspace()->getId()));

  	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($booking);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'Modifications bien enregistrées.');

      return $this->redirectToRoute('becowo_manager_booking_add');
    }

  	return $this->render('Manager/booking/addBooking.html.twig', array('form' => $form->createView()));
  }


}
