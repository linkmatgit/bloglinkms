<?php

namespace App\Domain\Auth\Security;

use App\Domain\Auth\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait BanTrait
{

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    public bool $banned = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    public ?\DateTimeInterface $bannedAt;
  /**
   * @return bool
   */
    public function isBanned(): bool
    {
        return $this->banned;
    }

  /**
   * @param bool $banned
   */
    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;
        return $this;
    }

  /**
   * @return \DateTimeInterface|null
   */
    public function getBannedAt(): ?\DateTimeInterface
    {
        return $this->bannedAt;
    }

  /**
   * @param \DateTimeInterface|null $bannedAt

   */
    public function setBannedAt(?\DateTimeInterface $bannedAt): self
    {
        $this->bannedAt = $bannedAt;
        return $this;
    }
}
