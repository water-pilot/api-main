<?php


namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

class AuthenticationSuccessListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $this->logger->notice('onAuthenticationSuccessResponse is called');

        $data = $event->getData();
        $token = $data['token'];

        $event->setData(['token' => $token]);
    }
}
