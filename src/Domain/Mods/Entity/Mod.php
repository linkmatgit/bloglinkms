<?php

declare(strict_types=1);

namespace App\Domain\Mods\Entity;

use App\Domain\Auth\User;
use App\Domain\Manager\Manageable;
use App\Domain\Mods\Repository\ModRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Regex;

#[ORM\Entity(repositoryClass: ModRepository::class)]
class Mod
{
    use Manageable;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $version = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $author;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }


    public function setAuthor(User $author): self
    {
        $this->author = $author;
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
