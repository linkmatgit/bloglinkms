<?php

declare(strict_types=1);

namespace App\Domain\WIP\Repository;

use App\Domain\Blog\Entity\Category;
use App\Domain\Group\Entity\Group;
use App\Domain\WIP\Entity\WipTag;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<WipTag>
 */
class WipRepository extends AbstractRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WipTag::class);
    }
}
