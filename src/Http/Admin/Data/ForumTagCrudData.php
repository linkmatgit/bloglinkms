<?php

namespace App\Http\Admin\Data;

use App\Domain\Auth\User;
use App\Domain\Forum\Entity\Tag;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @property Tag $entity
 */
class ForumTagCrudData extends AutomaticCrudData
{

    #[Assert\NotBlank]
    public ?string $name;

    #[Assert\NotBlank]
    public ?string $slug;

    public ?string $description;

    public ?string $color;

    public User $author;

    public bool $online = true;

    public ?Tag $parent = null;

    public function hydrate(): void
    {
        parent::hydrate();
        $this->entity->setUpdatedAt(new \DateTime());
    }
}
