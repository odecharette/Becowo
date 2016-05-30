<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Becowo\CoreBundle\Form\ContactType;
use Becowo\CoreBundle\Entity\Contact;


class ContactController extends Controller
{
  public function contactAction(Request $request)
  {
    $contact = new Contact();

    $form = $this->createForm(ContactType::class, $contact);

    
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject($form->get('subject')->getData())
                ->setFrom($form->get('email')->getData())
                ->setTo('webmaster@becowo.com')
                ->setBody(
                    $this->renderView(
                        'BecowoCoreBundle:Mail:contact.html.twig',
                        array(
                            'ip' => $request->getClientIp(),
                            'name' => $form->get('name')->getData(),
                            'message' => $form->get('message')->getData()
                        )
                    )
                );

            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('becowo_core_contact');
    }


    return $this->render('BecowoCoreBundle:Footer:contact.html.twig', array(
      'form' => $form->createView(),
    ));
  
  }
}
