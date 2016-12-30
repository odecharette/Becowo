<?php

namespace Becowo\MemberBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Bundle\FrameworkBundle\Routing\Router;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {       
        $previousURL = $request->getSession()->get('previousURL'); 

        // On renvoi vers l'URL précédente, sauvée en session via fichier login.html.twig ou register_content.html.twig
        if($previousURL != null or $previousURL != ''){
            return new RedirectResponse($previousURL);
        } else{
            return $this->redirectToRoute('becowo_core_homepage');
        }

    }
}
