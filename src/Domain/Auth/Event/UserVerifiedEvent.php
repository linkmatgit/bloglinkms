<?php

declare(strict_types=1);

namespace App\Domain\Auth\Event;

use App\Domain\Auth\User;

class UserVerifiedEvent
{
    public function __construct(private User $user)
    {
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
