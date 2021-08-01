<?php

declare(strict_types=1);

namespace App\Domain\Mods\Event;

use App\Domain\Mods\Entity\Mod;

class ModUpdatedEvent
{
    public function __construct(private Mod $mod)
    {
    }
    /**
     * @return Mod
     */
    public function getMod(): Mod
    {
        return $this->mod;
    }
}
