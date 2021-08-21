<?php

declare(strict_types=1);

namespace App\Http\Admin\Data;

use App\Domain\Auth\User;
use App\Domain\Group\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @property Group $entity
 */
class GroupeCrudData extends AutomaticCrudData
{

    private ?EntityManagerInterface $em = null;
    public ?string $name;
    private \DateTimeInterface $createdAt;
    public User $author;
    public string $color;
    public ?string $description = ' ';
    public ?string $imageFile;

    public function hydrate(): void
    {
        parent::hydrate();
        $this->entity->setUpdatedAt(new \DateTime());
    }

}
