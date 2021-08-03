<?php

declare(strict_types=1);

namespace App\Domain\Manager\Dto;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Mod;

class ManageableDto
{

    /* if approuve*/
    public int $statut = 0;
    public int $approuve = 0;
    public ?\DateTimeInterface $approuveAt;
    public ?User $approuveBy = null;
    public ?string $urlOfMod = null;
    public ?Mod $mod;

    /* if reject*/
    public ?int $rejetTime = null;
    public ?string $detail = null;

    public function __construct(Mod $mod)
    {
        $this->statut = $mod->getStatut();
        $this->approuve = $mod->getApprouve();
        $this->approuveAt = $mod->getApprouveAt();
        $this->approuveBy = $mod->getApprouveBy();
        $this->urlOfMod = $mod->getUrlOfMod();
        $this->rejetTime = $mod->getRejetTime();
        $this->detail = $mod->getDetail();
        $this->mod = $mod;
    }

    public function getId(): int
    {
        return $this->mod->getId() ?: 0;
    }
}
