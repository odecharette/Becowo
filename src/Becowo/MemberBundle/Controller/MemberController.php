<?php

namespace Becowo\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Becowo\CoreBundle\Form\Type\ContactType;
use Becowo\CoreBundle\Entity\Contact;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class MemberController extends Controller
{
  private $em = null;
  private $mailer = null;
  private $templating = null;
  private $appMember = null;

  public function __construct(EntityManager $em, $mailer, EngineInterface $templating, $appMember)
  {
      $this->em = $em;
      $this->mailer = $mailer;
      $this->templating = $templating;
      $this->appMember = $appMember;
  }

  public function viewPublicProfileAction(Request $request, $id)
  {
  	$MemberService = $this->get('app.member');
  	$member = $MemberService->getMemberById($id);

  	$WsService = $this->get('app.workspace');
  	$wsBooked = $WsService->getWsBookedByMemberId($id);

    $listCommunityNetwork = $WsService->getCommunityNetworkByMember($member);

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

        return $this->redirectToRoute('becowo_member_community_coworker', array('city' => str_replace('-',' ',$member->getCity()), 'job' => str_replace('-',' ',$member->getJob()), 'id' => $id));
      }

  	return $this->render('Member/viewPublicProfile.html.twig', 
      array('member' => $member, 'wsBooked' =>$wsBooked, 'listCommunityNetwork' => $listCommunityNetwork, 'form' => $form->createView()));
  }

  public function sendEmailToNewUsersAction()
  {
    // To call this method, use the command declared in Becowo\CronBundle\Command\EmailNewUserCommand 
    // php bin/console app:send-email-new-users

  	$members = $this->appMember->getMembersHasNotReceivedMailNewUser();
  	$nbMembers = 0;
  	$nbEmails = 0;
  	$listEmails = "";
    
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
	            $this->templating->render(
	                'CommonViews/Mail/NewMember.html.twig',
	                array('member' => $member)
	            ))
          ;

	      	$this->mailer->send($message);
	      	$nbEmails++;
	      	$listEmails = $listEmails . "\n" . $member->getEmail() ;

	      	$member->setHasReceivedEmailNewUser(true);
	      	
	  		$this->em->persist($member);
  		}
  	}
      $this->em->flush();

  	$result = " Nombre de nouveaux membres : " . $nbMembers . "\n Nombre d'emails envoyes : " . $nbEmails . "\n Liste des emails : " . $listEmails ;
    

  	return $result;
  }

}
