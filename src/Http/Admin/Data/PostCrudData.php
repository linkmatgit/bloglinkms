<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Auth\User;
use App\Domain\Blog\Entity\Category;
use App\Domain\Blog\Entity\Post;
use App\Http\Form\AutomaticForm;
use Doctrine\ORM\EntityManagerInterface;

class PostCrudData implements CrudDataInterface
{

    private ?EntityManagerInterface $em = null;
    private Post $entity;
    public ?string $title;
    public ?string $slug;
    public ?Category $category;
    public ?string $content;
    public bool $online;
    public ?\DateTimeInterface $createdAt;
    public User $author;


    public function __construct(Post $row)
    {
        $this->entity = $row;
        $this->title = $row->getTitle();
        $this->category = $row->getCategory();
        $this->content = $row->getContent();
        $this->online = $row->isOnline();
        $this->createdAt = $row->getCreatedAt();
        $this->slug = $row->getSlug();
        $this->author = $row->getAuthor();
    }
    public function hydrate(): void
    {
        $this->entity->setAuthor($this->author);
        $this->entity->setTitle($this->title);
        $this->entity->setSlug($this->slug);
        $this->entity->setContent($this->content);
        $this->entity->setCategory($this->category);
        $this->entity->setCreatedAt($this->createdAt);
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

    public function getEntity(): Post
    {
        return $this->entity;
    }
}
