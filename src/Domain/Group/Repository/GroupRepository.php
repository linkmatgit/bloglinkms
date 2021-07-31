<?php

declare(strict_types=1);

namespace App\Domain\Group\Repository;

use App\Domain\Blog\Entity\Category;
use App\Domain\Group\Entity\Group;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Category>
 */
class GroupRepository extends AbstractRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }
}
