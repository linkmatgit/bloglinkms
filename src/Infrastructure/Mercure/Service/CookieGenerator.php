<?php


namespace App\Infrastructure\Mercure\Service;

use App\Domain\Auth\User;
use App\Domain\Notification\Service\NotificationService;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token\Builder;
use Symfony\Component\HttpFoundation\Cookie;

class CookieGenerator
{

    public function __construct(private string $secret, private NotificationService $notificationService)
    {
        $this->secret = $secret;
        $this->notificationService = $notificationService;
    }
    public function generate(User $user): Cookie
    {


        $channels = array_map(
            fn (string $channel) => "/notifications/$channel",
            $this->notificationService->getChannelsForUser($user)
        );
        $token = (new Builder())
            ->withClaim('mercure', [
                'subscribe' => $channels,
            ])
            ->getToken($configuration->signer(), new $configuration->signingKey());

        return Cookie::create('mercureAuthorization', $token, 0, '/.well-known/mercure');
    }



}
