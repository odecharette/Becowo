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
use Symfony\Component\HttpFoundation\Session\Session;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RegistrationController extends BaseController
{
	public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);
        
        // Modif olivia to add sendNewsletter field
        $user->setSendNewsletter(true);
        $form->add('sendNewsletter', CheckboxType::class,  array('required' => false, 'label' => 'Recevoir la newsletter'));

        $form->handleRequest($request);

		$response = $this->render('FOSUserBundle:Registration:register.html.twig', array('form' => $form->createView()));
        
        if ($form->isValid()) {

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
	            $url = $this->generateUrl('fos_user_registration_confirmed');
	            $response = new RedirectResponse($url);
        	}

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

        }

        return $response;
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        $session = new Session();
        $session->getFlashBag()->add('success', 'Félicitations ' . $user->getUsername() . ', votre compte est maintenant activé.');

        return $this->redirectToRoute('becowo_core_homepage');
    }
}
