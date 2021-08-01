<?php declare(strict_types=1);

namespace App\Domain\Manager;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Auth\User;
use Symfony\Component\Validator\Constraints as Assert;

const OUVERT = 1;
const FERMER = 2;

const PENDING = 0;
const APPROUVE = 1;
const DECLINE = 2;
const REVISION = 3;

trait Manageable
{


    #[ORM\Column(type: Types::SMALLINT, options: ['default' => -1])]
    private int $statut = 0;

    #[ORM\Column(type: Types::SMALLINT, options: ['default' => 0])]
    private int $approuve = 0;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $approuveAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'approuveby_id', referencedColumnName: 'id')]
    private ?User $approuveBy = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Assert\Length(min: 3, minMessage: 'Le message doit un minimum de 3 character')]

    private ?string $detail = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $urlOfMod = null;


    public static array $status = [
        OUVERT => 'Ouvert',
        FERMER => 'Fermé',
    ];

    public static array $confirm = [
        PENDING => 'EN ATTENTE',
        APPROUVE => 'APPROUVER',
        DECLINE => 'REFUSER',
        REVISION => 'REVISION'
    ];

    public function getStatut(): int
    {
        return $this->statut;
    }

    public function getStatusName(): string
    {
        return self::$status[$this->statut];
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * @return int
     */
    public function getApprouve(): int
    {
        return $this->approuve;
    }

    /**
     * @param int $approuve
     */
    public function setApprouve(int $approuve): void
    {
        $this->approuve = $approuve;
    }


    public function getApprouveName(): string
    {
        return self::$confirm[$this->approuve];
    }

    /**
     * @param \DateTimeInterface|null $approuveAt
     */
    public function setApprouveAt(?\DateTimeInterface $approuveAt): void
    {
        $this->approuveAt = $approuveAt;
    }

    /**
     * @return User|null
     */
    public function getApprouveBy(): ?User
    {
        return $this->approuveBy;
    }

    /**
     * @param User|null $approuveBy
     */
    public function setApprouveBy(?User $approuveBy): void
    {
        $this->approuveBy = $approuveBy;
    }

    /**
     * @return string|null
     */
    public function getDetail(): ?string
    {
        return $this->detail;
    }

    /**
     * @param string|null $detail
     */
    public function setDetail(?string $detail): void
    {
        $this->detail = $detail;
    }

    /**
     * @return string|null
     */
    public function getUrlOfMod(): ?string
    {
        return $this->urlOfMod;
    }

    /**
     * @param string|null $urlOfMod
     */
    public function setUrlOfMod(?string $urlOfMod): void
    {
        $this->urlOfMod = $urlOfMod;
    }

    /**
     * @return array|string[]
     */
    public static function getStatus(): array
    {
        return self::$status;
    }

    /**
     * @param array|string[] $status
     */
    public static function setStatus(array $status): void
    {
        self::$status = $status;
    }


}