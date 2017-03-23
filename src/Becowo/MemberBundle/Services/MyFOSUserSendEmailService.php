<?php

namespace Becowo\MemberBundle\Services;

use FOS\UserBundle\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Routing\Router;

class MyFOSUserSendEmailService implements MailerInterface
{
	private $emailService = null;
	private $router = null;

    public function __construct($emailService, Router $router)
    {
        $this->emailService = $emailService;
        $this->router = $router;
    }

	/**
     * Send an email to a user to confirm the account creation
     *
     * @param UserInterface $user
     */
    function sendConfirmationEmailMessage(UserInterface $user)
    {
        $emailTemplate = "FOS-checkEmail";
        $url = $this->router->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);

        $emailParams = array('username' => $user->getUsername(),
                          'confirmationUrl' => $url);
        $emailTag = "Inscription - Confirmation email";
        $to = $user->getEmail();
        $subject = "[Becowo] Bienvenue " . $user->getUsername() . " !";

        $result = $this->emailService->sendEmail($emailTemplate, $emailParams, $emailTag, $to, $subject);    	
    }

    /**
     * Send an email to a user to confirm the password reset
     *
     * @param UserInterface $user
     */
    function sendResettingEmailMessage(UserInterface $user)
    {
    	// Not used 
    	// $url = $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
