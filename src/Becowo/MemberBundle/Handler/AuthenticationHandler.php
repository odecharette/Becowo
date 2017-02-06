<?php

namespace Becowo\MemberBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {     
    return new RedirectResponse($referer_url = $request->headers->get('referer'));  
        // $previousURL = $request->getSession()->get('previousURL'); 
        // // On renvoi vers l'URL précédente, sauvée en session via fichier login.html.twig ou register_content.html.twig
        // if($previousURL !== null && $previousURL !== ''){
        //     return new RedirectResponse($previousURL);
        // } else{
        //     $router = $this->get('router');
        //     return new RedirectResponse($router->generate('becowo_core_homepage'));
        // }

    }
}
