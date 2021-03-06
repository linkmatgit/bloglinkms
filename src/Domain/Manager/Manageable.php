<?php declare(strict_types=1);

namespace App\Domain\Manager;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Auth\User;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;

const OUVERT = 0;
const FERMER = 1;

const PENDING = 0;
const APPROUVE = 1;
const DECLINE = 2;
const REVISION = 3;

trait Manageable
{


    #[ORM\Column(type: Types::SMALLINT, options: ['default' => 0])]
    private int $statut = 0;

    #[ORM\Column(type: Types::SMALLINT, options: ['default' => 0])]
    private int $approuve = 0;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $acceptAdmin = false;

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

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $rejetTime = null;

    #[ORM\ManyToOne(targetEntity: Reason::class)]
    #[ORM\JoinColumn(name: 'reason_id', referencedColumnName: 'id')]
    private ?Reason $reason = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default'=> false])]
    private bool $noErrors = false;

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
     * @return \DateTimeInterface|null
     */
    public function getApprouveAt(): ?\DateTimeInterface
    {
        return $this->approuveAt;
    }

    /**
     * @param \DateTimeInterface|null $approuveAt
     * @return Manageable
     */
    public function setApprouveAt(?\DateTimeInterface $approuveAt): Manageable
    {
        $this->approuveAt = $approuveAt;
        return $this;
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
     * @return int|null
     */
    public function getRejetTime(): ?int
    {
        return $this->rejetTime;
    }

    /**
     * @param int|null $rejetTime
     * @return Manageable
     */
    public function setRejetTime(?int $rejetTime): self
    {
        $this->rejetTime = $rejetTime;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAcceptAdmin(): bool
    {
        return $this->acceptAdmin;
    }

    public function setAcceptAdmin(bool $acceptAdmin): self
    {
        $this->acceptAdmin = $acceptAdmin;
        return $this;
    }

    /**
     * @return Reason|null
     */
    public function getReason(): ?Reason
    {
        return $this->reason;
    }


    public function setReason(?Reason $reason): self
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNoErrors(): bool
    {
        return $this->noErrors;
    }

    /**
     * @param bool $noErrors
     * @return Manageable
     */
    public function setNoErrors(bool $noErrors): self
    {
        $this->noErrors = $noErrors;
        return $this;
    }


}
