<?php

declare(strict_types=1);

namespace App\Domain\Mods\Entity;

use App\Domain\Auth\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table("mods_category")]
class Category
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING)]
    private string $name = '';

    #[ORM\Column(type: Types::STRING)]
    private string $slug = '';

    #[ORM\Column(type: Types::STRING)]
    private string $description = '';

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $position = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?User $author = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' =>  false])]
    private bool $online = false;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Mod::class)]
    private Collection $mods;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default'=> 0])]
    private int $modsCount = 0;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'children')]
    private ?Category $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Category::class)]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $children;

    public function __construct()
    {
        $this->mods = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int|null $position
     */
    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }



    /**
     * @return bool
     */
    public function isOnline(): bool
    {
        return $this->online;
    }

    /**
     * @param bool $online
     */
    public function setOnline(bool $online): void
    {
        $this->online = $online;
    }
    /**
     * @return ArrayCollection|Collection
     */
    public function getMods(): ArrayCollection|Collection
    {
        return $this->mods;
    }

    /**
     * @param ArrayCollection|Collection $mods
     * @return Category
     */
    public function setMods(ArrayCollection|Collection $mods): Category
    {
        $this->mods = $mods;
        return $this;
    }


    public function addMod(Mod $mods): self
    {
        if (!$this->mods->contains($mods)) {
            $this->mods[] = $mods;
            $mods->setCategory($this);
        }

        return $this;
    }

    public function removeMod(Mod $mods): self
    {
        if ($this->mods->contains($mods)) {
            $this->mods->removeElement($mods);
            if ($mods->getCategory() === $this) {
                $mods->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getModsCount(): int
    {
        return $this->modsCount;
    }

    /**
     * @param int $modsCount
     */
    public function setModsCount(int $modsCount): void
    {
        $this->modsCount = $modsCount;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

}
