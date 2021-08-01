<?php


namespace App\Domain\Mods\Repository;


use App\Domain\Auth\User;
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
    public function queryModNotApprouveByUser(User $user): Query {

        $query = $this->createQueryBuilder('m')
            ->where('m.author = :user')
            ->orderBy('m.id', 'DESC')
            ->andWhere('m.approuve = 0')
            ->andWhere('m.rejetTime < 4')
            ->setMaxResults(4)
            ->setParameter('user', $user)
            ->getQuery();
        return  $query;
    }
    public function queryModApprouveByUser(User $user): Query {

        $query = $this->createQueryBuilder('m')
            ->where('m.author = :user')
            ->orderBy('m.id', 'DESC')
            ->andWhere('m.approuve = 1')
            ->setMaxResults(4)
            ->setParameter('user', $user)
            ->getQuery();
        return  $query;
    }
}