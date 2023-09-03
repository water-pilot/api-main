<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $response = $event->getResponse();
        $data = $event->getData();
        $token = $data['token'];

        // Création du cookie
        $cookie = new Cookie(
            'BEARER',        // Nom du cookie
            $token,          // Valeur du token
            new \DateTime('+1 hour'),  // Expiration du cookie, ajustez selon vos besoins
            '/',             // Chemin
            null,            // Domaine
            true,            // Sécurisé
            true,            // httpOnly
            false,
            'strict'
        );

        // Ajoute le cookie à la réponse
        $response->headers->setCookie($cookie);
    }

    // Implémentation de la méthode requise par l'interface
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        // Ici, vous pouvez renvoyer une réponse appropriée ou laisser votre logique actuelle gérer cela.
        return new Response("Authentication successful"); // exemple simple
    }
}
