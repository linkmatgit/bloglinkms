<?php

declare(strict_types=1);

namespace App\Http\Admin\Data\Mods;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Category;
use App\Http\Admin\Data\CrudDataInterface;
use App\Http\Form\AutomaticForm;
use Doctrine\ORM\EntityManagerInterface;

class CategoryCrudData implements CrudDataInterface
{

    private ?EntityManagerInterface $em = null;
    private Category $entity;
    public ?string $name;
    public ?string $description;
    public bool $online;
    public \DateTimeInterface $createdAt;
    public ?string $slug;
    public ?int $position;
    public User $author;

    public function __construct(Category $row)
    {
        $this->entity = $row;
        $this->name = $row->getName();
        $this->description = $row->getDescription();
         $this->online = $row->isOnline();
        $this->createdAt = $row->getCreatedAt();
        $this->slug = $row->getSlug();
        $this->position = $row->getPosition();
        $this->author = $row->getAuthor();
    }
    public function hydrate(): void
    {
        $this->entity->setName($this->name);
        $this->entity->setDescription($this->description);
        $this->entity->setOnline($this->online);
        $this->entity->setCreatedAt($this->createdAt);
        $this->entity->setSlug($this->slug);
        $this->entity->setUpdatedAt(new \DateTime());
        $this->entity->setPosition($this->position);
        $this->entity->setAuthor($this->author);
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

    public function getEntity(): Category
    {
        return $this->entity;
    }
}
