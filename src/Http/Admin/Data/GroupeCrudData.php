<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Auth\User;
use App\Domain\Blog\Entity\Category;
use App\Domain\Blog\Entity\Post;
use App\Domain\Group\Entity\Group;
use App\Http\Form\AutomaticForm;
use Doctrine\ORM\EntityManagerInterface;

class GroupeCrudData implements CrudDataInterface
{

    private ?EntityManagerInterface $em = null;
    private Group $entity;
    public ?string $name;
    public \DateTimeInterface $createdAt;
    public User $author;
    public ?User $members;

    public function __construct(Group $row)
    {
        $this->entity = $row;
        $this->name = $row->getName();
        $this->createdAt = $row->getCreatedAt();
        $this->author = $row->getAuthor();
    }
    public function hydrate(): void
    {
        $this->entity->setAuthor($this->author);
        $this->entity->setName($this->name);
        $this->entity->setCreatedAt($this->createdAt);
        $this->entity->setUpdatedAt(new \DateTime());
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

    public function getEntity(): Group
    {
        return $this->entity;
    }
}
