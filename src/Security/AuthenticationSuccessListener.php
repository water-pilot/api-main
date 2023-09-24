<?php


namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;
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

        // $data = $event->getData();
        // $token = $data['token'];

        // $event->setData(['token' => $token]);

        $response = $event->getResponse();
        $token = $event->getData()['token'];
        $response->headers->setCookie(new Cookie(
            'BEARER',                      // Nom du cookie
            $token,                        // Valeur du cookie
            (new \DateTime())->modify('+1 hour'), // Date d'expiration
            '/',                           // Chemin
            null,                          // Domaine
            true,                          // Secure
            true,                          // HttpOnly
            false,                         // Raw
            'lax'                         // SameSite
        ));

        // Supprimer le token du corps de la réponse
        $event->setData([]);
    }
}
