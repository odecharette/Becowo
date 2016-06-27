<?php

namespace Becowo\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookingController extends Controller
{
  public function viewAction()
  {
  	return $this->render('Manager/booking.html.twig');
  }


}