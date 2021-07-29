<?php

namespace App\Repository;

use App\Entity\AppDomainLoginAttempsLoginAttemps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AppDomainLoginAttempsLoginAttemps|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppDomainLoginAttempsLoginAttemps|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppDomainLoginAttempsLoginAttemps[]    findAll()
 * @method AppDomainLoginAttempsLoginAttemps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppDomainLoginAttempsLoginAttempsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppDomainLoginAttempsLoginAttemps::class);
    }

    // /**
    //  * @return AppDomainLoginAttempsLoginAttemps[] Returns an array of AppDomainLoginAttempsLoginAttemps objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppDomainLoginAttempsLoginAttemps
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
