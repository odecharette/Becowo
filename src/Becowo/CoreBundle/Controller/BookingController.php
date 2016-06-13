<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\ContactType;
use Becowo\CoreBundle\Entity\Contact;


class BookingController extends Controller
{
  public function myReservationsAction(Request $request)
  {
    $bookings = $this->getDoctrine()->getManager()->getRepository('BecowoCoreBundle:Booking')->findBy(
        array('member' => $this->getUser() ),
        array('createdOn' => 'DESC'));

    return $this->render('Booking/myReservations.html.twig', array('bookings' => $bookings));
  }
}
