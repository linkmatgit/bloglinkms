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
    use Manageable;
    use Sluggeable;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $version = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $url = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'creator_id', referencedColumnName: 'id')]
    private ?User $creator;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $console = false;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'mods')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Category $category = null;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'target')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Brand $brand = null;


    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }


    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;
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

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand|null $brand
     * @return Mod
     */
    public function setBrand(?Brand $brand): Mod
    {
        $this->brand = $brand;
        return $this;
    }
}
