<?php


namespace App\Domain\Mods\Repository;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Category;
use App\Domain\Mods\Entity\Mod;
use App\Infrastructure\Orm\AbstractRepository;
use Doctrine\ORM\Query;
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
    public function queryModNotApprouveByUser(User $user): Query
    {

        $query = $this->createQueryBuilder('m')
            ->where('m.author = :user')
            ->orderBy('m.createdAt', 'ASC')
            ->andWhere('m.approuve = 0')
            ->andWhere('m.statut != 1')
            ->setMaxResults(8)
            ->setParameter('user', $user)
            ->getQuery();
        return  $query;
    }
    public function queryModApprouveByUser(User $user): Query
    {

        $query = $this->createQueryBuilder('m')
            ->where('m.author = :user')
            ->orderBy('m.id', 'DESC')
            ->andWhere('m.approuve = 1')
            ->setMaxResults(4)
            ->setParameter('user', $user)
            ->getQuery();
        return  $query;
    }

    public function findRecentMod(): Query
    {
        $query = $this->createQueryBuilder('m')
            ->leftJoin('m.category', 'category')
            ->leftJoin('m.author', 'author')
            ->leftJoin('m.brand', 'brand')
            ->select('m', 'category', 'author', 'brand')
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery();

        return $query;
    }

    public function findForCategory(?Category $category = null):Query
    {

        $query = $this->createQueryBuilder('m')
            ->leftJoin('m.category', 'category')
            ->leftJoin('m.author', 'author')
            ->leftJoin('m.brand', 'brand')
            ->select('m', 'category', 'author', 'brand')
            ->where('m.approuve = 1 AND m.createdAt < NOW()')
            ->orderBy('m.createdAt', 'DESC');

        if ($category) {
            $query = $query
                ->andWhere('m.category = :category')
                ->setParameter('category', $category);
        }


        return $query->getQuery();
    }
    public function findForBrand(?Category $category = null):Query
    {

        $query = $this->createQueryBuilder('m')
            ->leftJoin('m.category', 'category')
            ->leftJoin('m.author', 'author')
            ->leftJoin('m.brand', 'brand')
            ->select('m', 'category', 'author', 'brand')
            ->where('m.approuve = 0 AND m.createdAt < NOW()')
            ->orderBy('m.createdAt', 'DESC');

        if ($category) {
            $query = $query
                ->leftJoin('m.category', 'category')
                ->leftJoin('m.author', 'author')
                ->leftJoin('m.brand', 'brand')
                ->select('m', 'category', 'author', 'brand')
                ->where('m.approuve = 0 AND m.createdAt < NOW()')
                ->orderBy('m.createdAt', 'DESC')
                ->andWhere('m.category = :category')
                ->setParameter('category', $category);
        }


        return $query->getQuery();
    }
}
