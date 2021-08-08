<?php

namespace App\Domain\Mods\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait Informable
{
    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    public bool $info;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    public ?string $power;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    public ?string $price;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    public ?string $wheel;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    public ?string $grandeur;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    public ?string $champs;

    /**
     * @return bool
     */
    public function isInfo(): bool
    {
        return $this->info;
    }

    /**
     * @param bool $info
     * @return Informable|Mod
     */
    public function setInfo(bool $info): self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPower(): ?string
    {
        return $this->power;
    }

    /**
     * @param string|null $power
     * @return Informable|Mod
     */
    public function setPower(?string $power): self
    {
        $this->power = $power;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string|null $price
     * @return Informable|Mod
     */
    public function setPrice(?string $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWheel(): ?string
    {
        return $this->wheel;
    }

    /**
     * @param string|null $wheel
     * @return Informable|Mod
     */
    public function setWheel(?string $wheel): self
    {
        $this->wheel = $wheel;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrandeur(): ?string
    {
        return $this->grandeur;
    }

    /**
     * @param string|null $grandeur
     * @return Informable|Mod
     */
    public function setGrandeur(?string $grandeur): self
    {
        $this->grandeur = $grandeur;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getChamps(): ?string
    {
        return $this->champs;
    }

    /**
     * @param string|null $champs
     * @return Informable|Mod
     */
    public function setChamps(?string $champs): self
    {
        $this->champs = $champs;
        return $this;
    }


}