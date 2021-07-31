<?php

namespace App\Infrastructure\Security;

class TokenGeneratorService
{

    /**
     * @throws \Exception
     */
    public function generate(int $length): string
    {

        return substr(bin2hex(random_bytes((int) ceil($length / 2))), 0, $length);
    }
}
