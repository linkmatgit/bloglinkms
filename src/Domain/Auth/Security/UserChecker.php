<?php

declare(strict_types=1);

namespace App\Domain\Auth\Security;

use App\Domain\Auth\Exception\UserBannedException;
use App\Domain\Auth\Exception\UserNotFoundException;
use App\Domain\Auth\Exception\UserNotVerifiedException;
use App\Domain\Auth\User;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user)
    {
    }

    public function checkPostAuth(UserInterface $user)
    {
        if ($user instanceof  User && $user->isBanned()) {
            throw  new UserBannedException();
        }
        if ($user instanceof User && true !== $user->isVerified()) {
            throw new UserNotVerifiedException();
        }

        return;
    }
}
