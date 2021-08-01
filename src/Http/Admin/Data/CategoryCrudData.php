<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Auth\User;
use App\Domain\Blog\Entity\Category;
use App\Http\Form\AutomaticForm;
use Doctrine\ORM\EntityManagerInterface;

class CategoryCrudData implements CrudDataInterface
{
    private Category $entity;

    private EntityManagerInterface $em;

    public ?string $name;

    public ?string $slug;

    public ?string $description;

    public string $color = "#000000";

    public bool $online = false;

    public \DateTimeInterface $createdAt;

    public User $author;

    public function __construct(Category $row)
    {
        $this->entity = $row;
       $this->name =  $row->getName();
        $this->description = $row->getDescription();
        $this->online = $row->isOnline();
        $this->createdAt = $row->getCreatedAt();
        $this->author = $row->getAuthor();
        $this->color = $row->getColor();
        $this->slug = $row->getSlug();
    }

    public function hydrate(): void
    {
        $this->entity->setAuthor($this->author);
        $this->entity->setName($this->name);
        $this->entity->setSlug($this->slug);
        $this->entity->setCreatedAt($this->createdAt);
        $this->entity->setUpdatedAt(new \DateTime());
        $this->entity->setOnline($this->online);
        $this->entity->setColor($this->color);
    }

    public function setEntityManager(EntityManagerInterface $em): self
    {
        $this->em = $em;

        return $this;
    }
    public function getEntity(): object
    {
        return  $this->entity;
    }

    public function getFormClass(): string
    {
        return AutomaticForm::class;
    }
}
