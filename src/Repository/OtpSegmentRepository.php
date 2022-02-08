<?php

namespace App\Repository;

use App\Entity\OtpSegment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OtpSegment|null find($id, $lockMode = null, $lockVersion = null)
 * @method OtpSegment|null findOneBy(array $criteria, array $orderBy = null)
 * @method OtpSegment[]    findAll()
 * @method OtpSegment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OtpSegmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OtpSegment::class);
    }

    // /**
    //  * @return OtpSegment[] Returns an array of OtpSegment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OtpSegment
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
