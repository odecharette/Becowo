<?php
// Controller surchargé sur la base de C:\wamp64\www\Becowo\vendor\hwi\oauth-bundle\Controller\ConnectController.php

namespace Becowo\MemberBundle\Controller;

use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class ConnectController extends Symfony\Component\DependencyInjection\ContainerAware
{
    public function registrationAction(Request $request, $key)
    {
        $connect = $this->container->getParameter('hwi_oauth.connect');
        if (!$connect) {
            throw new NotFoundHttpException();
        }

        $hasUser = $this->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if ($hasUser) {
            throw new AccessDeniedException('Cannot connect already registered account.');
        }

        $session = $request->getSession();
        $error = $session->get('_hwi_oauth.registration_error.'.$key);
        $session->remove('_hwi_oauth.registration_error.'.$key);
        if (!$error instanceof AccountNotLinkedException || time() - $key > 300) {
            // todo: fix this
            throw new \Exception('Cannot register an account.');
        }

        $userInformation = $this
            ->getResourceOwnerByName($error->getResourceOwnerName())
            ->getUserInformation($error->getRawToken())
        ;

        if ($this->container->getParameter('hwi_oauth.fosub_enabled')) {
            // enable compatibility with FOSUserBundle 1.3.x and 2.x
            if (interface_exists('FOS\UserBundle\Form\Factory\FactoryInterface')) {
                $form = $this->container->get('hwi_oauth.registration.form.factory')->createForm();
            } else {
                $form = $this->container->get('hwi_oauth.registration.form');
            }
        } else {
            $form = $this->container->get('hwi_oauth.registration.form');
        }


        $formHandler = $this->container->get('hwi_oauth.registration.form.handler');
        if ($formHandler->process($request, $form, $userInformation)) {
            $this->container->get('hwi_oauth.account.connector')->connect($form->getData(), $userInformation);

            // Authenticate the user
            $this->authenticateUser($request, $form->getData(), $error->getResourceOwnerName(), $error->getRawToken());

            // if ($targetPath = $this->getTargetPath($session)) {
            //     return $this->redirect($targetPath);
            // }

            // return $this->render('HWIOAuthBundle:Connect:registration_success.html.'.$this->getTemplatingEngine(), array(
            //     'userInformation' => $userInformation,
            // ));
             // Getting user
            $user = $this->container->get('security.context')->getToken()->getUser();
 
            // Getting social network source
            $source = $userInformation->getResourceOwner()->getName();
 
            // Updating user by source
            switch ($source) {
                case 'facebook':
                    $user = $this->handleFacebookResponse($userInformation, $user);
                    break;
            }
 
            // Saving User
            $em = $this->container->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            
            // Redirect the user to homepage
            $url = $this->container->get('router')->generate(
                'becowo_core_homepage'
            );
            return new RedirectResponse($url);
        }

        // reset the error in the session
        $key = time();
        $session->set('_hwi_oauth.registration_error.'.$key, $error);

        return $this->render('HWIOAuthBundle:Connect:registration.html.'.$this->getTemplatingEngine(), array(
            'key' => $key,
            'form' => $form->createView(),
            'userInformation' => $userInformation,
        ));
    }

    public function handleFacebookResponse($response, $user) {
        // User is from Facebook : DO STUFF HERE \o/
        // All data from Facebook
        $data = $response->getResponse();
        // His profile image : file_get_contents('https://graph.facebook.com/' . $response->getUsername() . '/picture?type=large')
 
        return $user;
    }

}
