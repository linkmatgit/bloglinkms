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
use Symfony\Component\Validator\Constraints as Assert;

class ModCrudData implements CrudDataInterface
{

    private ?EntityManagerInterface $em = null;
    private Mod $entity;
    #[Assert\NotBlank]
    public ?string $title;

    #[Assert\Url]
    #[Assert\NotBlank]
    public ?string $url;
    #[Assert\NotBlank]
    public ?Category $category = null;
    public ?string $content;
    public ?\DateTimeInterface $createdAt;
    public User $author;
    public ?User $creator;
    #[Assert\NotBlank]
    public ?string $version;
    public bool $console = false;
    #[Assert\NotBlank]
    public ?Brand $brand ;

    public function __construct(Mod $row)
    {
        $this->entity = $row;
        $this->title = $row->getTitle();
        $this->category = $row->getCategory();
        $this->content = $row->getContent();
        $this->createdAt = $row->getCreatedAt();
        $this->author = $row->getAuthor();
        $this->url = $row->getUrl();
        $this->version = $row->getVersion();
        $this->brand = $row->getBrand();
    }
    public function hydrate(): void
    {
        $this->entity->setAuthor($this->author);
        $this->entity->setTitle($this->title);
        $this->entity->setContent($this->content);
        $this->entity->setCategory($this->category);
        $this->entity->setCreatedAt($this->createdAt);
        $this->entity->setUrl($this->url);
        $this->entity->setVersion($this->version);
        $this->entity->setBrand($this->brand);
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
