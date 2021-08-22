<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Auth\User;
use App\Domain\WIP\Entity\WipTag;
use App\Http\Form\AutomaticForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

class WipCrudData implements CrudDataInterface
{

    private ?EntityManagerInterface $em = null;
    private WipTag $entity;
    public ?string $name;
    public User $author;
    public ?\DateTimeInterface $createdAt;
    public ?string $content;

    public function __construct(WipTag $row)
    {
        $this->entity = $row;
        $this->name = $row->getName();
        $this->author = $row->getAuthor();
        $this->createdAt = $row->getCreatedAt();
        $this->content = $row->getContent();

    }
    public function hydrate(): void
    {

        $this->entity->setName($this->name);
        $this->entity->setAuthor($this->author);
        $this->entity->setCreatedAt($this->createdAt);
        $this->entity->setContent($this->content);
    }
    public function slugify():string {
        return strtolower(preg_replace('/[^a-z0-9\-]/', '',preg_replace('/\s+/', '-', $this->name) ));

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

    public function getEntity(): WipTag
    {
        return $this->entity;
    }
}
