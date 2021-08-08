<?php

declare(strict_types=1);

namespace App\Domain\Mods\Entity;

use App\Domain\Application\Entity\Content;
use App\Domain\Application\Entity\Sluggeable;
use App\Domain\Auth\User;
use App\Domain\Manager\Manageable;
use App\Domain\Mods\Repository\ModRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModRepository::class)]
class Mod extends Content
{

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $version = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $console = false;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'mods')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Category $category = null;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'target')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Brand $brand = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $server = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $cgu = false;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id', nullable: true)]
    private ?User $credit;

    use Manageable;
    use Sluggeable;
    use Informable;

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public function isConsole(): bool
    {
        return $this->console;
    }

    public function setConsole(bool $console): self
    {
        $this->console = $console;
        return $this;
    }


    public function getCategory(): ?Category
    {
        return $this->category;
    }


    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }


    public function getUrl(): ?string
    {
        return $this->url;
    }


    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }


    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }


    public function isServer(): bool
    {
        return $this->server;
    }


    public function setServer(bool $server): self
    {
        $this->server = $server;
        return $this;
    }

    public function isCgu(): bool
    {
        return $this->cgu;
    }

    public function setCgu(bool $cgu): self
    {
        $this->cgu = $cgu;
        return $this;
    }

    public function getCredit(): ?User
    {
        return $this->credit;
    }

    public function setCredit(?User $credit): Mod
    {
        $this->credit = $credit;
        return $this;
    }



}
