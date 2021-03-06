<?php

namespace App\Domain\Mods\Entity;

use App\Domain\Auth\User;
use App\Domain\Blog\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table('mods_brand')]
class Brand
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $online = false;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $author;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: Mod::class)]
    private Collection $target;

    public function __construct()
    {
        $this->target = new ArrayCollection();
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
     * @return Brand
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Brand
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return Brand
     */
    public function setSlug(?string $slug): Brand
    {
        $this->slug = $slug;
        return $this;
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
     * @return Brand
     */
    public function setOnline(bool $online): Brand
    {
        $this->online = $online;
        return $this;
    }


    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Brand
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return Brand
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface $updatedAt
     * @return Brand
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getTarget(): ArrayCollection|Collection
    {
        return $this->target;
    }

    /**
     * @param ArrayCollection|Collection $target
     * @return Brand
     */
    public function setTarget(ArrayCollection|Collection $target): Brand
    {
        $this->target = $target;
        return $this;
    }


    public function addPost(Mod $target): self
    {
        if (!$this->target->contains($target)) {
            $this->target[] = $target;
            $target->setBrand($this);
        }

        return $this;
    }

    public function removePost(Mod $target): self
    {
        if ($this->target->contains($target)) {
            $this->target->removeElement($target);
            // set the owning side to null (unless already changed)
            if ($target->getBrand() === $this) {
                $target->setBrand(null);
            }
        }

        return $this;
    }
}
