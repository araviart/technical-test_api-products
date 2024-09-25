<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    private string $validApiKey;

    public function __construct(string $validApiKey)
    {
        $this->validApiKey = $validApiKey;
    }

    public function supports(Request $request): ?bool
    {
        // Vérifie si une clé API est présente dans l'en-tête
        return $request->headers->has('X-API-KEY');
    }

    public function authenticate(Request $request): Passport
    {
        // Récupère la clé API envoyée dans l'en-tête
        $apiKey = $request->headers->get('X-API-KEY');

        return new SelfValidatingPassport(new UserBadge($apiKey, function ($apiKey) {
            // Compare la clé API envoyée avec celle définie dans l'environnement
            if ($apiKey !== $this->validApiKey) {
                throw new AuthenticationException('Invalid API Key');
            }

            // Pas besoin de retourner un utilisateur spécifique, on valide juste l'authentification
            return null;
        }));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['error' => 'Invalid API Key'], Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, $token, string $firewallName): ?Response
    {
        // Si l'authentification réussit, pas de réponse particulière nécessaire
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null): ?Response
    {
        // Réponse lorsque l'authentification est nécessaire mais non fournie
        return new JsonResponse(['error' => 'API Key required'], Response::HTTP_UNAUTHORIZED);
    }
}
