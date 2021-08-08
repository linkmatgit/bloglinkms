<?php

declare(strict_types=1);

namespace App\Http\Admin\Data\Mods;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Mod;
use App\Http\Admin\Data\AutomaticCrudData;

class ModWeekCrudData extends AutomaticCrudData
{
    public ?Mod $choice1 = null;
    public ?Mod $choice2 = null;
    public ?Mod $choice3 = null;
    public ?Mod $choice4 = null;
    public ?Mod $choice5 = null;
    public ?Mod $choice10 = null;
    public ?Mod $choice6 = null;
    public ?Mod $choice7 = null;
    public ?Mod $choice8 = null;
    public ?Mod $choice9 = null;
    public ?User $author = null;
    public \DateTimeInterface $createdAt;
}
