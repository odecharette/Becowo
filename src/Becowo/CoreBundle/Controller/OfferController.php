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
            $converter = $this->get('css_to_inline_email_converter');
            $converter->setCSS($this->get('kernel')->getRootDir().'/../web/css/emails.css');
            
            $converter->setHTMLByView('CommonViews/Mail/Offer-contact.html.twig',
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
                        ));

            $message = \Swift_Message::newInstance()
                ->setSubject('[Becowo] - Nouveaux contact d\'un espace de coworking')
                ->setFrom(array('contact@becowo.com' => 'Contact Becowo'))
                ->setTo('contact@becowo.com')
                ->setBcc('webmaster@becowo.com')
                ->setContentType("text/html")
                ->setBody($converter->generateStyledHTML());
                
            try{
              $this->get('mailer')->send($message);
            }catch(Exception $e){
              echo "error sending email : ",  $e->getMessage(), "\n";
            }

            $request->getSession()->getFlashBag()->add('success', 'Votre message a bien été envoyé ');

            return $this->redirectToRoute('becowo_core_offers');
    }

  	return $this->render('Offer/view.html.twig', array( 'form' => $form->createView(), 'name' => '' ));
  }



}
