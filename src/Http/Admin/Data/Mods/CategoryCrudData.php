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
    public string $name;
    public string $slug;
    public string $description;
    public bool $online;
    public ?\DateTimeInterface $createdAt;
    public User $author;
    public ?User $creator;
    public ?Category $parent;
    public ?int $position;

    public function __construct(Category $row)
    {
        $this->entity = $row;
        $this->name = $row->getName();
        $this->description = $row->getDescription();
        $this->online = $row->isOnline();
        $this->createdAt = $row->getCreatedAt();
        $this->slug = $row->getSlug();
        $this->author = $row->getAuthor();
        $this->parent = $row->getParent();
        $this->position = $row->getPosition();
    }
    public function hydrate(): void
    {
        $this->entity->setAuthor($this->author);
        $this->entity->setName($this->name);
        $this->entity->setSlug($this->slug);
        $this->entity->setDescription($this->description);
        $this->entity->setCreatedAt($this->createdAt);
        $this->entity->setUpdatedAt(new \DateTime());
        $this->entity->setOnline($this->online);
        $this->entity->setParent($this->parent);
        $this->entity->setPosition($this->position);
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
