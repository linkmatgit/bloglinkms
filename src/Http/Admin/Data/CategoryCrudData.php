<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Auth\User;

class CategoryCrudData extends AutomaticCrudData
{

    public ?string $name;

    public ?string $slug;

    public ?string $description;

    public string $color = "#000000";

    public bool $online = false;

    public \DateTimeInterface $createdAt;

    public User $author;


    public function hydrate(): void
    {
        parent::hydrate();
        $this->entity->setUpdatedAt(new \DateTime());
    }
}
