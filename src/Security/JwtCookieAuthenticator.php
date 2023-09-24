<?php

// src/Security/JwtCookieAuthenticator.php

namespace App\Security;

use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class JwtCookieAuthenticator extends AbstractAuthenticator
{
    private $logger;
    private $jwtEncoder;

    public function __construct(LoggerInterface $logger, JWTEncoderInterface $jwtEncoder)
    {
        $this->logger = $logger;
        $this->jwtEncoder = $jwtEncoder;
    }

    public function supports(Request $request): ?bool
    {
        $this->logger->notice('supports is called');
        return $request->cookies->has('BEARER');
    }

    public function authenticate(Request $request): Passport
{
    $token = $request->cookies->get('BEARER');// Récupérez le token JWT du cookie comme vous le faites actuellement
    $this->logger->notice('authenticate is called '. $token);
    if (!$token) {
        // Gérez l'erreur comme vous le souhaitez, par exemple :
        throw new CustomUserMessageAuthenticationException('Token JWT manquant.');
    }
    try {
        $decodedToken = $this->jwtEncoder->decode($token);
        $username = $decodedToken['username']; // ou tout autre champ que vous avez dans le token
    } catch (\Exception $e) {
        throw new CustomUserMessageAuthenticationException('Token JWT invalide.');
    }

    // Utilisez $username ou d'autres données du token décodé comme vous le souhaitez
    return new SelfValidatingPassport(new UserBadge($username));
}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Gestion de la réussite de l'authentification
        return null; // continuez avec la requête
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $this->logger->notice('onAuthenticationFailure is called');
        // Gestion de l'échec de l'authentification
        return null; // continuez avec la requête
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $this->logger->notice('getUser is called');
        // Cette méthode est nécessaire pour l'interface, mais nous n'en avons pas besoin ici
        return null;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $this->logger->notice('checkCredentials is called');
        
        // Cette méthode est nécessaire pour l'interface, mais nous n'en avons pas besoin ici
        return true;
    }
}
