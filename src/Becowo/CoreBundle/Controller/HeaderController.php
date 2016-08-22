<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class HeaderController extends Controller
{
  
  public function declarerEspaceAction(Request $request)
  {

    $defaultData = array('description' => '');
    $form = $this->createFormBuilder($defaultData)
        ->add('email', EmailType::class, array('label' => 'Votre email *', 'required' => true))
        ->add('nomEspace', TextType::class, array('label' => 'Le nom de l\'espace'))
        ->add('website', TextType::class, array('label' => 'Site web'))
        ->add('description', TextareaType::class, array('label' => 'Racontez-nous votre expérience *', 'required' => true))
        // ->add('Envoyer', SubmitType::class)
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
       $data = $form->getData();
            $message = \Swift_Message::newInstance()
                ->setSubject('Un coworker déclare un nouvel espace')
                ->setFrom($data['email'])
                ->setTo('webmaster@becowo.com')
                ->setBody(
                    $this->renderView(
                        'CommonViews/Mail/declarer-espace.html.twig',
                        array(
                            'email' => $data['email'],
                            'nomEspace' => $data['nomEspace'],
                            'website' => $data['website'],
                            'description' => $data['description']
                        )
                    )
                );

            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('becowo_core_declare_ws');
    }

    return $this->render('Header/declarer-espace.html.twig', array('form' => $form->createView()));
  }
}
