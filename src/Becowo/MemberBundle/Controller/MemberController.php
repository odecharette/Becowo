<?php

namespace Becowo\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MemberController extends Controller
{
  public function viewPublicProfileAction($id)
  {
  	$MemberService = $this->get('app.member');
  	$member = $MemberService->getMemberById($id);

  	$WsService = $this->get('app.workspace');
  	$wsBooked = $WsService->getWsBookedByMemberId($id);

  	return $this->render('Member/viewPublicProfile.html.twig', array('member' => $member, 'wsBooked' =>$wsBooked));
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
