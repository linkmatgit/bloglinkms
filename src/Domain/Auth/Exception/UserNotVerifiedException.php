<?php

namespace App\Domain\Auth\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class UserNotVerifiedException extends AuthenticationException
{
  public function __construct()
  {
    parent::__construct('', 0, null);
  }

  public function getMessageKey()
  {
    return 'Votre Compte n\'a pas ete validée';
  }
}
