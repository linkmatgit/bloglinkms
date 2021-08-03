<?php


namespace App\Infrastructure\Mercure\Service;

use App\Domain\Auth\User;
use App\Domain\Notification\Service\NotificationService;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Config\Mercure\HubConfig\JwtConfig;

class CookieGenerator
{

    public function __construct(
        private NotificationService $notificationService,
        private string $secret
    ) {
    }


    public function generate(User $user): Cookie
    {
        $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($this->secret));
        $channels = array_map(
            fn (string $channel) =>
            "/notifications/$channel",
            $this->notificationService->getChannelsForUser($user)
        );
        $token = $config->builder()->permittedFor()
            ->withClaim('mercure', [
                'subscribe' => $channels,
            ])
            ->getToken($config->signer(), $config->signingKey());

        $y = $token->toString();

        return Cookie::create(
            'mercureAuthorization',
            $y,
            0,
            '/.well-known/mercure'
        );
    }
}
