<?php

declare(strict_types=1);

namespace App\Http\Admin\Data\Mods;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Brand;
use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Entity\Mod;
use App\Http\Admin\Data\CrudDataInterface;
use App\Http\Form\AutomaticForm;
use App\Http\Form\ModsFormType;
use Doctrine\ORM\EntityManagerInterface;

class ModCrudData implements CrudDataInterface
{

    private ?EntityManagerInterface $em = null;
    private Mod $entity;
    public ?string $name;
    public ?string $url;
    public ?Category $category = null;
    public ?string $description;
    public ?\DateTimeInterface $createdAt;
    public User $author;
    public ?User $creator;
    public ?string $version;
    public bool $console = false;

    public function __construct(Mod $row)
    {
        $this->entity = $row;
        $this->name = $row->getName();
        $this->category = $row->getCategory();
        $this->description = $row->getDescription();
        $this->createdAt = $row->getCreatedAt();
        $this->author = $row->getAuthor();
        $this->url = $row->getUrl();
        $this->version = $row->getVersion();
    }
    public function hydrate(): void
    {
        $this->entity->setAuthor($this->author);
        $this->entity->setName($this->name);
        $this->entity->setDescription($this->description);
        $this->entity->setCategory($this->category);
        $this->entity->setCreatedAt($this->createdAt);
        $this->entity->setUrl($this->url);
        $this->entity->setVersion($this->version);
    }

    public function getFormClass(): string
    {
        return ModsFormType::class;
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
