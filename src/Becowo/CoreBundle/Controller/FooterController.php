<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\Type\ContactType;
use Becowo\CoreBundle\Entity\Contact;


class FooterController extends Controller
{
  public function contactAction(Request $request)
  {
    $contact = new Contact();

    $form = $this->createForm(ContactType::class, $contact);

    
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Becowo - Nouveau message')
                ->setFrom('contact@becowo.com')
                ->setTo('contact@becowo.com')
                ->setContentType("text/html")
                ->setBody(
                    $this->renderView(
                        'CommonViews/Mail/Footer-contact.html.twig',
                        array(
                            'name' => $form->get('name')->getData(),
                            'email' => $form->get('email')->getData(),
                            'subject' => $form->get('subject')->getData(),
                            'message' => $form->get('message')->getData()
                        )
                    )
                );

            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('becowo_core_contact');
    }


    return $this->render('Footer/contact.html.twig', array(
      'form' => $form->createView(),
    ));
  
  }

  public function aProposAction()
  {
    return $this->render('Footer/apropos.html.twig');
  }

  public function faqAction()
  {
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository('BecowoCoreBundle:Faq');
    $faq = $repo->findAll();

    $repo = $em->getRepository('BecowoCoreBundle:FaqCategory');
    $faqCategory = $repo->findAll();

    return $this->render('Footer/faq.html.twig', array('faq' => $faq, 'faqCategory' => $faqCategory));
  }

  public function cguAction()
  {
    return $this->render('Footer/cgu.html.twig');
  }

  public function mentionsAction()
  {
    return $this->render('Footer/mentions.html.twig');
  }

  public function cookiesAction()
  {
    return $this->render('Footer/cookies.html.twig');
  }

  public function paiementAction()
  {
    return $this->render('Footer/paiement.html.twig');
  }

  public function commentCaMarcheCoworkersAction()
  {
    return $this->render('Footer/comment-ca-marche-coworkers.html.twig');
  }

  public function commentCaMarcheEspacesAction()
  {
    return $this->render('Footer/comment-ca-marche-espaces.html.twig');
  }

  // public function ambassadeurAction()
  // {
  //   return $this->render('Footer/ambassadeur.html.twig');
  // }

}
