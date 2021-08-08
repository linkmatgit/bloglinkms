<?php


namespace App\Domain\Mods\Repository;

use App\Domain\Mods\Entity\Category;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Category>
 */
class CategoryRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findWithCount(): array
    {
        $data = $this->createQueryBuilder('c')
            ->join('c.mods', 'm')
            ->groupBy('c.id')
            ->select('c', 'COUNT(c.id) as count')
            ->getQuery()
            ->getResult();
        return array_map(function (array $d) {
            $d[0]->setModsCount((int) $d['count']);

            return $d[0];
        }, $data);
    }
}
