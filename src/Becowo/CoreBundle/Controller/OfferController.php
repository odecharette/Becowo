<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\ContactOfferType;
use Becowo\CoreBundle\Entity\ContactOffer;

class OfferController extends Controller
{
  public function viewAction()
  {
  	return $this->render('Offer/view.html.twig');
  }

  public function contactAction($name, Request $request)
  {
  	$contact = new ContactOffer();

    $form = $this->createForm(ContactOfferType::class, $contact);

    
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('[Becowo] - Nouveaux contact d\'un espace de coworking')
                ->setFrom($form->get('email')->getData())
                ->setTo('webmaster@becowo.com')
                ->setBody(
                    $this->renderView(
                        'CommonViews/Mail/contact.html.twig',
                        array(
                            'wsName' => $form->get('wsName')->getData(),
                            'street' => $form->get('street')->getData(),
                            'postCode' => $form->get('postCode')->getData(),
                            'city' => $form->get('city')->getData(),
                            'phone' => $form->get('phone')->getData(),
                            'nbDesk' => $form->get('nbDesk')->getData(),
                            'comments' => $form->get('comments')->getData()
                        )
                    )
                );

            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('becowo_core_offers');
    }


    return $this->render('Offer/contact.html.twig', array(
      'form' => $form->createView(), 'name' => $name
    ));

  }


}