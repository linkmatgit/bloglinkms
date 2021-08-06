<?php

declare(strict_types=1);

namespace App\Domain\Mods\Entity;

use App\Domain\Auth\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class WeekMods
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice1 = null;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice2 = null;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice3 = null;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice4 = null;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice5 = null;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice6 = null;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice7 = null;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice8 = null;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice9 = null;

    #[ORM\ManyToOne(targetEntity: Mod::class)]
    private ?Mod $choice10 = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $author;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return WeekMods
     */
    public function setId(?int $id): WeekMods
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice1(): ?Mod
    {
        return $this->choice1;
    }

    /**
     * @param Mod|null $choice1
     * @return WeekMods
     */
    public function setChoice1(?Mod $choice1): self
    {
        $this->choice1 = $choice1;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice2(): ?Mod
    {
        return $this->choice2;
    }

    /**
     * @param Mod|null $choice2
     * @return WeekMods
     */
    public function setChoice2(?Mod $choice2): self
    {
        $this->choice2 = $choice2;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice3(): ?Mod
    {
        return $this->choice3;
    }

    /**
     * @param Mod|null $choice3
     * @return WeekMods
     */
    public function setChoice3(?Mod $choice3): self
    {
        $this->choice3 = $choice3;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice4(): ?Mod
    {
        return $this->choice4;
    }

    public function setChoice4(?Mod $choice4): self
    {
        $this->choice4 = $choice4;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice5(): ?Mod
    {
        return $this->choice5;
    }

    /**
     * @param Mod|null $choice5
     * @return WeekMods
     */
    public function setChoice5(?Mod $choice5): self
    {
        $this->choice5 = $choice5;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice6(): ?Mod
    {
        return $this->choice6;
    }

    /**
     * @param Mod|null $choice6
     * @return WeekMods
     */
    public function setChoice6(?Mod $choice6): self
    {
        $this->choice6 = $choice6;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice7(): ?Mod
    {
        return $this->choice7;
    }

    /**
     * @param Mod|null $choice7
     * @return WeekMods
     */
    public function setChoice7(?Mod $choice7): self
    {
        $this->choice7 = $choice7;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice8(): ?Mod
    {
        return $this->choice8;
    }

    /**
     * @param Mod|null $choice8
     * @return WeekMods
     */
    public function setChoice8(?Mod $choice8): self
    {
        $this->choice8 = $choice8;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice9(): ?Mod
    {
        return $this->choice9;
    }

    /**
     * @param Mod|null $choice9
     * @return WeekMods
     */
    public function setChoice9(?Mod $choice9): self
    {
        $this->choice9 = $choice9;
        return $this;
    }

    /**
     * @return Mod|null
     */
    public function getChoice10(): ?Mod
    {
        return $this->choice10;
    }

    /**
     * @param Mod|null $choice10
     * @return WeekMods
     */
    public function setChoice10(?Mod $choice10): self
    {
        $this->choice10 = $choice10;
        return $this;
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
     * @return WeekMods
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
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
     * @return WeekMods
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
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
     * @return WeekMods
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;
        return $this;
    }


}
