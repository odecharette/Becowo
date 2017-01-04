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

  	foreach ($members as $member) {
  		$nbMembers++;
  		if($member->getEmail() !== null)
  		{
  			$message = \Swift_Message::newInstance()
	        ->setSubject("Becowo - Intégrez notre communauté")
	        ->setFrom('contact@becowo.com')
	        ->setTo($member->getEmail())
	        ->setBody(
	            $this->renderView(
	                'CommonViews/Mail/NewMember.html.twig',
	                array('member' => $member)
	            ));

	      	$this->get('mailer')->send($message);
	      	$nbEmails++;
	      	$listEmails = $listEmails . "<br>" . $member->getEmail() ;

	      	$member->setHasReceivedEmailNewUser(true);
	      	$em = $this->getDoctrine()->getManager();
	  		$em->persist($member);
  		}
  	}
      $em->flush();

  	$result = "Nombre de nouveaux membres : " . $nbMembers . "<br> Nombre d'emails envoyés : " . $nbEmails . "<br> Liste des emails : " . $listEmails ;

  	return $this->render('CommonViews/Mail/NewMemberResult.html.twig', array('result' => $result));
  }

}
