<?php
declare(strict_types=1);

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Entity\Category;
use App\Domain\Blog\Entity\Post;
use App\Infrastructure\Orm\AbstractRepository;
use App\Infrastructure\Orm\IterableQueryBuilder;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends AbstractRepository<Post>
 */
class PostRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @return IterableQueryBuilder<Post>
     */
    public function findRecent(int $limit): IterableQueryBuilder
    {
        return $this->createIterableQuery('p')
            ->select('p')
            ->where('p.online = true AND p.createdAt < NOW()')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit);
    }

    public function queryAll(?Category $category = null): Query
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.author', 'u')
            ->addSelect('c', 'u')
            ->where('p.online = true AND p.createdAt < NOW()')
            ->orderBy('p.createdAt', 'DESC');

        if ($category) {
            $query = $query
                ->leftJoin('p.category', 'c')
                ->leftJoin('p.author', 'u')
                ->addSelect('c', 'u')
                ->andWhere('p.category = :category')
                ->setParameter('category', $category);
        }

        return $query->getQuery();
    }
}
