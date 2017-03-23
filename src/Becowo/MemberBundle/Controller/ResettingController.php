<?php

// This controller is an override of FOSUserBundle in vendor
// To cancel redirect to stay in pop'in

namespace Becowo\MemberBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\UserBundle\Controller\ResettingController as BaseController;

class ResettingController extends BaseController
{
	public function sendEmailAction(Request $request)
    {
        $username = $request->request->get('username');

        /** @var $user UserInterface */
        $user = $this->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        if (null === $user) {
            return $this->render('FOSUserBundle:Resetting:request.html.twig', array(
                'error' => 'Pseudo ou Email invalide'
            ));
        }

        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            $request->getSession()->getFlashBag()->add('danger', 'Une demande de réinitialisation a déjà été envoyée');
            return $this->render('FOSUserBundle:Resetting:request.html.twig', array(
                'error' => ''
            ));
        }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->get('fos_user.mailer')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->get('fos_user.user_manager')->updateUser($user);

        $request->getSession()->getFlashBag()->add('success', 'Un e-mail a été envoyé à ' . $user->getEmail() . '. Il contient un lien afin de réinitialiser votre mot de passe.');

         return $this->render('FOSUserBundle:Resetting:request.html.twig', array(
                'error' => ''
            ));
    }
}
