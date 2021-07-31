<?php


namespace App\Domain\Mods\Repository;


use App\Domain\Mods\Entity\Mod;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Mod>
 */
class ModRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mod::class);
    }
}