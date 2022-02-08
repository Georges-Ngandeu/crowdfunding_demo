<?php

namespace App\Repository;

use App\Entity\OtpLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OtpLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method OtpLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method OtpLine[]    findAll()
 * @method OtpLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OtpLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OtpLine::class);
    }

    // /**
    //  * @return OtpLine[] Returns an array of OtpLine objects
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
    public function findOneBySomeField($value): ?OtpLine
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
