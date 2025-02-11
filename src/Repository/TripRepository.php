<?php

namespace App\Repository;

use App\Entity\Trip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trip>
 */
class TripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    /**
    * @return Trip[] Returns an array of Trip objects
    */
    public function findByRef($value): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.ref LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('t.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Trip
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
