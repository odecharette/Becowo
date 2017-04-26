<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Entity\Booking;
use Becowo\CoreBundle\Form\Type\BookingManagerType;

class BookingController extends Controller
{
  public function viewAction($id)
  {
  	$WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);

  	return $this->render('Manager/booking/booking.html.twig', array('workspace' => $workspace));
  }

  public function getBookingForCalendarAction(Request $request, $id)
  {
    $WsService = $this->get('app.workspace');

    //POST parameters
    $start = $request->request->get('start');
    $end = $request->request->get('end');

    $bookings = $WsService->getJsonReservationsByWorkspaceByDates($id, $start, $end);

    return $bookings;
  }

  public function addAction(Request $request, $id)
  {
    $WsService = $this->get('app.workspace');
    $workspace = $WsService->getWorkspaceById($id);

  	$booking = new Booking();
  	$booking->setMember(null); // booking interne, pas de member
  	$form = $this->get('form.factory')->createNamedBuilder('booking-add-form', BookingManagerType::class, $booking, array('idWs' => $id))
      ->setAction($this->generateUrl('becowo_manager_booking_add', array('id' => $id)))
      ->setMethod('POST')
      ->getForm();

  	if ($request->isMethod('POST')  && $form->handleRequest($request)->isValid()) {

      $em = $this->getDoctrine()->getManager();
      $em->persist($booking);
      $em->flush();

      return $this->redirectToRoute('becowo_manager_booking', array('id' => $id));
    }

  	return $this->render('Manager/booking/addBooking.html.twig', array('form' => $form->createView(), 'workspace' => $workspace));
  }


}
