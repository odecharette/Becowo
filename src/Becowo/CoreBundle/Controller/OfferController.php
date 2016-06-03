<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OfferController extends Controller
{
  public function viewAction()
  {
  	return $this->render('BecowoCoreBundle:Offers:offers.html.twig');
  }


}