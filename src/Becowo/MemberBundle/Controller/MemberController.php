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
  private $converter = null;

  public function __construct(EntityManager $em=null, $mailer=null, EngineInterface $templating=null, $appMember=null, $converter=null)
  {
      $this->em = $em;
      $this->mailer = $mailer;
      $this->templating = $templating;
      $this->appMember = $appMember;
      $this->converter = $converter;
  }

  public function viewPublicProfileAction(Request $request, $id)
  {
  	$MemberService = $this->get('app.member');
  	$member = $MemberService->getMemberById($id);

  	$WsService = $this->get('app.workspace');
  	$wsBooked = $WsService->getWsBookedByMemberId($id);

    $listCommunityNetwork = array_unique($WsService->getCommunityNetworkByMember($member));

    $contact = new Contact();
    if($this->getUser() != null){
      $prenom = $this->getUser()->getFirstname() == null ? '' : $this->getUser()->getFirstname();
      $nom = $this->getUser()->getName() == null ? '' : $this->getUser()->getName();
      $mail = $this->getUser()->getEmail() == null ? '' : $this->getUser()->getEmail();
      $contact->setName($prenom . ' ' . $nom);
      $contact->setEmail($mail);
    }

    $form = $this->createForm(ContactType::class, $contact);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $emailService = $this->get('app.email');
        $emailTemplate = "Coworker-contact";
        $emailParams = array('name' => $form->get('name')->getData(),
                        'email' => $form->get('email')->getData(),
                        'subject' => $form->get('subject')->getData(),
                        'destinataire' => $member->getFirstname() . ' ' . $member->getName() . ' (' . $member->getEmail() . ')',
                        'message' => $form->get('message')->getData());
        $emailTag = "Coworker contact";
        $to = "contact@becowo.com";
        $subject = "Becowo - Nouveau message pour un coworker";

        $result = $emailService->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);

        if($result)
          $request->getSession()->getFlashBag()->add('success', 'Votre message a bien été envoyé');
        else
          $request->getSession()->getFlashBag()->add('danger', 'Une erreur est survenue, veuillez réessayer plus tard');

        return $this->redirectToRoute('becowo_member_community_coworker', array('city' => str_replace('-',' ',$member->getCity()), 'job' => str_replace('/', ' ',str_replace('-',' ',$member->getJob())), 'id' => $id));
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
        $emailTemplate = "NewMember";
        $emailParams = array('member' => $member);
        $emailTag = "Mail de bienvenue";
        $to = $member->getEmail();
        $subject = "Becowo - Intégrez notre communauté";

        $resultEmail = $this->mailer->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);
            
        if($resultEmail)
        {
          $nbEmails++;
          $listEmails = $listEmails . "\n" . $member->getEmail() ;
          $member->setHasReceivedEmailNewUser(true);
        }
	      	
	  		$this->em->persist($member);
  		}
  	}
      $this->em->flush();

  	$result = " Nombre de nouveaux membres : " . $nbMembers . "\n Nombre d'emails envoyes : " . $nbEmails . "\n Liste des emails : " . $listEmails ;
    

  	return $result;
  }

  public function unsubscribeNewsletterAction($memberID)
  {
    $MemberService = $this->get('app.member');
    $member = $MemberService->getMemberById($memberID);

    $em = $this->getDoctrine()->getManager();

    if($member !== null)
    {
      $member->setSendNewsletter(false);
      $em->persist($member);
      $em->flush();

      $result = 'Vous avez bien été désinscrit de la Newsletter de Becowo';
    }else{
      $result = 'Aucun coworker pour l\'ID : ' . $memberID;
    }

    return $this->render('Member/unsubscribeNewsletter.html.twig', array('result' => $result));

  }

}
