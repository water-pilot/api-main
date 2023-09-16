<?php

// src/EventListener/JwtCookieListener.php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Psr\Log\LoggerInterface;

class JwtCookieListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
{
    $this->logger = $logger;
}
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->getMethod() === 'OPTIONS') {
            return;
        }

        // Si l'en-tête d'autorisation est déjà défini, ignorez.
        if ($request->headers->has('Authorization')) {
            return;
        }

        // Si le cookie contient le token JWT, ajoutez-le à l'en-tête d'autorisation.
        if ($request->cookies->has('BEARER')) {
            $token = $request->cookies->get('BEARER');
            $request->headers->set('Authorization', 'Bearer ' . $token);

            // Log the token
            $this->logger->info('JWT from cookie: ' . $token);
        }
    }
}
