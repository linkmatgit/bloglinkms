<?php

declare(strict_types=1);

namespace App\Http\Admin\Data\Mods;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Brand;
use App\Http\Admin\Data\CrudDataInterface;
use App\Http\Form\AutomaticForm;
use Doctrine\ORM\EntityManagerInterface;

class BrandsCrudData implements CrudDataInterface
{

    private ?EntityManagerInterface $em = null;
    private Brand $entity;
    public ?string $name;
    public ?string $slug;
    public bool $online;
    public ?\DateTimeInterface $createdAt;
    public ?User $author;

    public function __construct(Brand $row)
    {
        $this->entity = $row;
        $this->name = $row->getName();
        $this->online = $row->isOnline();
        $this->createdAt = $row->getCreatedAt();
        $this->slug = $row->getSlug();
        $this->author = $row->getAuthor();
    }
    public function hydrate(): void
    {
        $this->entity->setAuthor($this->author);
        $this->entity->setName($this->name);
        $this->entity->setSlug($this->slug);
        $this->entity->setCreatedAt($this->createdAt);
        $this->entity->setOnline($this->online);
    }

    public function getFormClass(): string
    {
        return AutomaticForm::class;
    }


    public function setEntityManager(EntityManagerInterface $em): self
    {
        $this->em = $em;

        return $this;
    }

    public function getEntity(): Brand
    {
        return $this->entity;
    }
}
