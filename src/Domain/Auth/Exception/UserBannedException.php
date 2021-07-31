<?php

namespace App\Domain\Auth\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class UserBannedException extends AuthenticationException
{
    public function __construct()
    {
        parent::__construct('', 0, null);
    }

    public function getMessageKey()
    {
        return 'Votre compte a été bannie';
    }
}
