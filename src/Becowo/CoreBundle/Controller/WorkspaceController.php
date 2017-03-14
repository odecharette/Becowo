<?php

namespace Becowo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\Type\ManagerContactType;
use Becowo\CoreBundle\Entity\Contact;
use Becowo\CoreBundle\Entity\Comment;
use Becowo\CoreBundle\Form\Type\CommentType;

class WorkspaceController extends Controller
{
  public function viewAction($name, Request $request)
  {
    $WsService = $this->get('app.workspace');

    $ws = $WsService->getWorkspaceByName($name);
    $pictures = $WsService->getPicturesByWorkspace($name);
    $listEvents = $WsService->getFuturEventsByWorkspaceOrderByDate($ws);
    $pricesAndOffices = $WsService->getPricesByWorkspace($ws);
    $WsHasTeamMembers = $WsService->getWsHasTeamMemberByWorkspace($ws);
    $wsSameNetwork = $WsService->getWsByWsNetwork($ws->getNetwork(), $name);
    $wsSameNetworkWithFavoritePic = array();
    $WsHasAmenities = $WsService->getAmenitiesByWorkspace($ws);
    $quantityByOfficeType = $WsService->getQuantityByOfficeType($ws);

    foreach ($wsSameNetwork as $w) {
      array_push($wsSameNetworkWithFavoritePic, 
        array('ws' => $w, 
              'amenities' => $WsService->getAmenitiesByWorkspace($w)));
    }

  	return $this->render('Workspace/view.html.twig', 
      array('ws' => $ws, 
        'listEvents' => $listEvents, 
        'pictures' => $pictures, 
        'pricesAndOffices' => $pricesAndOffices,
        'WsHasTeamMembers' => $WsHasTeamMembers,
        'wsSameNetworkWithFavoritePic' => $wsSameNetworkWithFavoritePic,
        'WsHasAmenities' => $WsHasAmenities,
        'quantityByOfficeType' => $quantityByOfficeType
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
    $managerContactForm = $this->get('form.factory')->createNamedBuilder('manager-contact-form', ManagerContactType::class, $contact)
      ->setAction($this->generateUrl('becowo_core_workspace_contact', array('name' => $name)))
      ->setMethod('POST')
      ->getForm();

    $WsService = $this->get('app.workspace');
    $ws = $WsService->getWorkspaceByName($name);
    // Pour le moment, on recoit les emails puis FW aux manager, afin de contrôler le flux
    // $wsHasTeamMembers = $WsService->getWsHasTeamMemberByWorkspace($ws);

    // $emailManager = [];
    // $i = 0;
    // if($wsHasTeamMembers == null || $this->container->get( 'kernel' )->getEnvironment() !== 'prod')
    // {
    //   $emailManager[0] = 'olivia.decharette@becowo.com';
    // }else{
    //   foreach ($wsHasTeamMembers as $wsHasTeamMember ) {
    //     $emailManager[$i] = $wsHasTeamMember->getTeamMember()->getEmail();
    //     $i ++;
    //   }
    // }
    
      // On vérifie que c'est bien le form de contact manager qui est envoyé
    if ($request->isMethod('POST') && $managerContactForm->handleRequest($request)->isValid() && $request->request->has('manager-contact-form')) {
      $message = \Swift_Message::newInstance()
          ->setSubject('Becowo - Nouveau message d\'un coworker')
          ->setFrom(array('contact@becowo.com' => 'Contact Becowo'))
          ->setTo('contact@becowo.com') 
          ->setBcc('webmaster@becowo.com')
          ->setContentType("text/html")
          ->setBody(
              $this->renderView(
                  'CommonViews/Mail/Manager-contact.html.twig',
                  array(
                      'name' => $managerContactForm->get('name')->getData(),
                      'email' => $managerContactForm->get('email')->getData(),
                      'subject' => $managerContactForm->get('subject')->getData(),
                      'message' => $managerContactForm->get('message')->getData(),
                      'wsName' => $ws->getName()
                  )
              )
          );

      $this->get('mailer')->send($message);

      $this->addFlash('success', 'Merci ! Email bien envoyé.');

      return $this->redirectToRoute('becowo_core_workspace_contact', array('name' => $name));
    }

    return $this->render('Workspace/manager-contact.html.twig', 
      array('managerContactForm' => $managerContactForm->createView(),
        'ws' =>$ws));
  }

   public function voteAndCommentAction($name, Request $request)
  {
    $WsService = $this->get('app.workspace');
    $ws = $WsService->getWorkspaceByName($request->get('name'));
    $listComments = $WsService->getCommentsByWorkspace($ws);
    $voteAlreadyDone = $WsService->memberAlreadyVoteAndCommentForWorkspace($ws, $this->getUser());

    // Création du formulaire de commentaires
    $comment = new Comment($ws, $this->getUser());
    $formComment = $this->get('form.factory')->createNamedBuilder('comment-form', CommentType::class, $comment)
      ->setAction($this->generateUrl('becowo_comment', array('name' => $name)))
      ->setMethod('POST')
      ->getForm();


    if ($request->isMethod('POST') && $formComment->handleRequest($request)->isValid() && $request->request->has('comment-form'))
    { 
      $em = $this->getDoctrine()->getManager();
      $em->persist($comment);
      $em->flush();

      $this->addFlash('success', 'Merci ! Commentaire et vote bien enregistrés.');

      return $this->redirectToRoute('becowo_comment', array('name' => $request->get('name')));
    }

    return $this->render('Workspace/comments.html.twig', array('formComment' => $formComment->createView(), 'listComments' => $listComments, 'ws' =>$ws, 'voteAlreadyDone' => $voteAlreadyDone));
  }


}
