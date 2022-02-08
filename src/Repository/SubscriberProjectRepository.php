<?php

namespace App\Repository;

use App\Entity\SubscriberProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubscriberProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriberProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriberProject[]    findAll()
 * @method SubscriberProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriberProject::class);
    }

    // /**
    //  * @return SubscriberProject[] Returns an array of SubscriberProject objects
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
    public function findOneBySomeField($value): ?SubscriberProject
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
