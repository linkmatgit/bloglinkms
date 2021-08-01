<?php

declare(strict_types=1);

namespace App\Http\Admin\Data\Mods;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Brand;
use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Entity\Mod;
use App\Http\Admin\Data\CrudDataInterface;
use App\Http\Form\AutomaticForm;
use Doctrine\ORM\EntityManagerInterface;

class ModCrudData implements CrudDataInterface
{

    private ?EntityManagerInterface $em = null;
    private Mod $entity;
    public ?string $title;
    public ?string $url;
    public ?Category $category;
    public ?Brand $brand;
    public ?string $content;
    public ?\DateTimeInterface $createdAt;
    public User $author;
    public ?User $creator;

    public function __construct(Mod $row)
    {
        $this->entity = $row;
        $this->title = $row->getName();
        $this->category = $row->getCategory();
        $this->content = $row->getDescription();
        $this->createdAt = $row->getCreatedAt();
        $this->author = $row->getAuthor();
        $this->url = $row->getUrlOfMod();
    }
    public function hydrate(): void
    {
        $this->entity->setAuthor($this->author);
        $this->entity->setName($this->title);
        $this->entity->setDescription($this->content);
        $this->entity->setCategory($this->category);
        $this->entity->setCreatedAt($this->createdAt);
        $this->entity->setUrlOfMod($this->url);
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

    public function getEntity(): Mod
    {
        return $this->entity;
    }
}
