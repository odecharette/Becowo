<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\Type\ContactType;
use Becowo\CoreBundle\Entity\Contact;

class WorkspaceController extends Controller
{
  public function viewAction($name, Request $request)
  {
    $WsService = $this->get('app.workspace');

    $ws = $WsService->getWorkspaceByName($name);
    $pictures = $WsService->getPicturesByWorkspace($name);
    $pictureLogo = $WsService->getLogoByWorkspace($name);
    $listEvents = $WsService->getEventsByWorkspace($ws);
    $averageVote = $WsService->getAverageVoteByWorkspace($ws);
    $pricesAndOffices = $WsService->getPricesByWorkspace($ws);
    $WsHasTeamMembers = $WsService->getWsHasTeamMemberByWorkspace($ws);

  	return $this->render('Workspace/view.html.twig', 
      array('ws' => $ws, 
        'listEvents' => $listEvents, 
        'pictures' => $pictures, 
        'pictureLogo' => $pictureLogo,
        'pricesAndOffices' => $pricesAndOffices,
        'averageVote' => $averageVote,
        'WsHasTeamMembers' => $WsHasTeamMembers
        ));
  }

  public function visitAction($name, Request $request)
  {
    $WsService = $this->get('app.workspace');
    $ws = $WsService->getWorkspaceByName($name);

    return $this->render('Workspace/visit360.html.twig', array('ws' => $ws));
  }

  public function contactAction($name, Request $request)
  {
    $contact = new Contact();
    $form = $this->createForm(ContactType::class, $contact);
    
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $message = \Swift_Message::newInstance()
          ->setSubject('Becowo - Nouveau message')
          ->setFrom('contact@becowo.com')
          ->setTo('contact@becowo.com') // TO DO envoyer au manager de l'espace
          ->setBody(
              $this->renderView(
                  'CommonViews/Mail/Manager-contact.html.twig',
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

      return $this->redirectToRoute('becowo_core_workspace', array('name' => $name));
    }

    return $this->render('Workspace/manager-contact.html.twig', 
      array('form' => $form->createView(),
        'name' =>$name));
  }


}
