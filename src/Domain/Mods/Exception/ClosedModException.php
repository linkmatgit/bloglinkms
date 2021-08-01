<?php

namespace App\Domain\Mods\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ClosedModException extends AuthenticationException
{
    public function __construct()
    {
        parent::__construct('', 0, null);
    }

    public function getMessageKey()
    {
        return 'Le Mod a ete fermer par un Administrateur ou un Communauty Manager';
    }
}
