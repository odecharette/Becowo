<?php

namespace Becowo\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\Type\ContactType;
use Becowo\CoreBundle\Entity\Contact;

class MemberController extends Controller
{
  public function viewPublicProfileAction(Request $request, $id)
  {
  	$MemberService = $this->get('app.member');
  	$member = $MemberService->getMemberById($id);

  	$WsService = $this->get('app.workspace');
  	$wsBooked = $WsService->getWsBookedByMemberId($id);

    $contact = new Contact();
    $contact->setName($member->getFirstname() . ' ' . $member->getName());
    $contact->setEmail($member->getEMail());

    $form = $this->createForm(ContactType::class, $contact);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $message = \Swift_Message::newInstance()
            ->setSubject('Becowo - Nouveau message pour un coworker')
            ->setFrom(array('contact@becowo.com' => 'Contact Becowo'))
            ->setTo('contact@becowo.com')
            ->setContentType("text/html")
            ->setBody(
                $this->renderView(
                    'CommonViews/Mail/Footer-contact.html.twig',
                    array(
                        'name' => $form->get('name')->getData(),
                        'email' => $form->get('email')->getData(),
                        'subject' => $form->get('subject')->getData(),
                        'message' => $this->getUser()->getFirstname() . ' ' . $this->getUser()->getName() . ' (' . $this->getUser()->getId() . ') souhaite contacter le coworker : ' . $member->getFirstname() . ' ' . $member->getName() . ' (' . $member->getId() . ') avec le message suivant : <br>' . $form->get('message')->getData()
                    )
                )
            );

        $this->get('mailer')->send($message);

        $request->getSession()->getFlashBag()->add('success', 'Votre message a bien été envoyé');

        return $this->redirectToRoute('becowo_member_public_profile', array('id' => $id));
      }

  	return $this->render('Member/viewPublicProfile.html.twig', array('member' => $member, 'wsBooked' =>$wsBooked, 'form' => $form->createView()));
  }

  public function sendEmailToNewUsersAction()
  {
    
  	$MemberService = $this->get('app.member');
  	$members = $MemberService->getMembersHasNotReceivedMailNewUser();
  	$nbMembers = 0;
  	$nbEmails = 0;
  	$listEmails = "";
    $em = $this->getDoctrine()->getManager();
    
  	foreach ($members as $member) {
  		$nbMembers++;
  		if($member->getEmail() !== null)
  		{
  			$message = \Swift_Message::newInstance()
	        ->setSubject("Becowo - Intégrez notre communauté")
	        ->setFrom(array('contact@becowo.com' => 'Contact Becowo'))
	        ->setTo($member->getEmail())
          ->setContentType("text/html")
	        ->setBody(
	            $this->renderView(
	                'CommonViews/Mail/NewMember.html.twig',
	                array('member' => $member)
	            ));

	      	$this->get('mailer')->send($message);
	      	$nbEmails++;
	      	$listEmails = $listEmails . "<br>" . $member->getEmail() ;

	      	$member->setHasReceivedEmailNewUser(true);
	      	
	  		$em->persist($member);
  		}
  	}
      $em->flush();

  	$result = "Nombre de nouveaux membres : " . $nbMembers . "<br> Nombre d'emails envoyés : " . $nbEmails . "<br> Liste des emails : " . $listEmails ;
    

  	return $this->render('CommonViews/Mail/NewMemberResult.html.twig', array('result' => $result));
  }

}
