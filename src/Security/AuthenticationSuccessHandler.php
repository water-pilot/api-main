<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Psr\Log\LoggerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $token = $data['token'];

        $this->logger->notice('onAuthenticationSuccessResponse is called');

        return new Response(json_encode(['token' => $token]), 200, ['Content-Type' => 'application/json']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        $this->logger->notice('Inside onAuthenticationSuccess');

        // Ici, nous supposons que le JWT sera traité dans la méthode onAuthenticationSuccessResponse 
        // et que nous n'avons rien de plus à faire ici.
        return new Response("Authentication successful"); 
    }
}
