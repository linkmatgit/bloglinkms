<?php declare(strict_types=1);

namespace App\Domain\Auth;

use App\Domain\Auth\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthService {


    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    public function getUserOrNull(): ?User
    {
    if(!$token = $this->tokenStorage->getToken()){
        return null;
    }
    $user = $token->getUser();
    if(!\is_object($user)) {
        return null;
    }
    if(!$user instanceof User) {
        return null;
    }
    return $user;

    }
}