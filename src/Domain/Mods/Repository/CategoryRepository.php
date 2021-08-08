<?php


namespace App\Domain\Mods\Repository;

use App\Domain\Mods\Entity\Category;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\ORM\Query;
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

    public function findCategory():Query {

        $query =  $this->createQueryBuilder('c')
            ->where('c.online =  true')
            ->orderBy('c.name', 'ASC')
            ->groupBy('c.parent')
            ->getQuery();

        return $query;
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

    public function findTree(): array
    {
        $query = $this->createQueryBuilder('t')
            ->andWhere('t.online = true')
            ->leftJoin('t.children', 'p')
            ->addSelect('p')
            ->orderBy('t.position', 'ASC');

        return array_values(array_filter(
            $query->getQuery()->getResult(),
            fn (Category $tag) => null === $tag->getParent()
        ));
    }

    public function findAllOrdered(): array
    {
        $parents = $this->findTree();
        $tags = [];
        foreach ($parents as $parent) {
            $tags[] = $parent;
            foreach ($parent->getChildren() as $child) {
                $tags[] = $child;
            }
        }

        return $tags;
    }
}
