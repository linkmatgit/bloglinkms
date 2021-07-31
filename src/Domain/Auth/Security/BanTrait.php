<?php

namespace App\Domain\Auth\Security;

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
   * @return BanTrait
   */
    public function setBanned(bool $banned): BanTrait
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
   * @return BanTrait
   */
    public function setBannedAt(?\DateTimeInterface $bannedAt): BanTrait
    {
        $this->bannedAt = $bannedAt;
        return $this;
    }
}
