<?php

declare(strict_types=1);

namespace App\Domain\Manager\Dto;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Mod;

class ManageableDto {

    /* if approuve*/
    private int $statut = 0;
    private int $approuve = 0;
    private ?\DateTimeInterface $approuveAt;
    private ?User $approuveBy = null;
    private ?string $urlOfMod = null;

    /* if reject*/
    private ?int $rejetTime = null;
    private ?string $detail = null;

    public function __construct(Mod $mod)
    {
        $this->statut = $mod->getStatut();
        $this->approuve = $mod->getApprouve();
        $this->approuveAt = $mod->getApprouveAt();
        $this->approuveBy = $mod->getApprouveBy();
        $this->urlOfMod = $mod->getUrlOfMod();
        $this->rejetTime = $mod->getRejetTime();
        $this->detail = $mod->getDetail();
    }

}