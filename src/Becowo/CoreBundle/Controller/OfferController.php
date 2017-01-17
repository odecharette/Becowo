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
            $message = \Swift_Message::newInstance()
                ->setSubject('[Becowo] - Nouveaux contact d\'un espace de coworking')
                ->setFrom(array('contact@becowo.com' => 'Contact Becowo'))
                ->setTo('contact@becowo.com')
                ->setContentType("text/html")
                ->setBody(
                    $this->renderView(
                        'CommonViews/Mail/contact.html.twig',
                        array(
                            'wsName' => $form->get('wsName')->getData(),
                            'street' => $form->get('street')->getData(),
                            'postCode' => $form->get('postCode')->getData(),
                            'city' => $form->get('city')->getData(),
                            'offer' => $form->get('offer')->getData(),
                            'contactName' => $form->get('contactName')->getData(),
                            'email' => $form->get('email')->getData(),
                            'phone' => $form->get('phone')->getData(),
                            'nbDesk' => $form->get('nbDesk')->getData(),
                            'comments' => $form->get('comments')->getData()
                        )
                    )
                );
            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('success', 'Votre message a bien été envoyé ');

            return $this->redirectToRoute('becowo_core_offers');
    }

  	return $this->render('Offer/view.html.twig', array( 'form' => $form->createView(), 'name' => '' ));
  }



}
