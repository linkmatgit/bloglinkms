<?php

namespace App\Domain\Application\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait Sluggeable
{
    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Assert\NotBlank]
    private ?string $slug = null;

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return Sluggeable
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

}