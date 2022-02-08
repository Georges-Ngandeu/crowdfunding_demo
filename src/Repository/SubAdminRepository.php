<?php

namespace App\Repository;

use App\Entity\SubAdmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubAdmin[]    findAll()
 * @method SubAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubAdminRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubAdmin::class);
    }

    // /**
    //  * @return SubAdmin[] Returns an array of SubAdmin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubAdmin
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
