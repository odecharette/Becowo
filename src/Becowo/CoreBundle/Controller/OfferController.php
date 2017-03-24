<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\Type\ContactOfferType;
use Becowo\CoreBundle\Entity\ContactOffer;

class OfferController extends Controller
{
  public function viewAction(Request $request)
  {
    $contact = new ContactOffer();

    $form = $this->createForm(ContactOfferType::class, $contact);
   
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $emailService = $this->get('app.email');
        $emailTemplate = "Offer-contact";
        $emailParams = array('wsName' => $form->get('wsName')->getData(),
                        'street' => $form->get('street')->getData(),
                        'postCode' => $form->get('postCode')->getData(),
                        'city' => $form->get('city')->getData(),
                        'offer' => $form->get('offer')->getData(),
                        'contactName' => $form->get('contactName')->getData(),
                        'email' => $form->get('email')->getData(),
                        'phone' => $form->get('phone')->getData(),
                        'nbDesk' => $form->get('nbDesk')->getData(),
                        'comments' => $form->get('comments')->getData());
        $emailTag = "Prospect offer contact";
        $to = "contact@becowo.com";
        $subject = "[Becowo] - Nouveaux contact d'un espace de coworking";

        $result = $emailService->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);

        if($result)
            $request->getSession()->getFlashBag()->add('success', 'Votre message a bien été envoyé');
        else
            $request->getSession()->getFlashBag()->add('danger', 'Une erreur est survenue, veuillez réessayer plus tard');

        return $this->redirectToRoute('becowo_core_offers');
    }

  	return $this->render('Offer/view.html.twig', array( 'form' => $form->createView(), 'name' => '' ));
  }



}
