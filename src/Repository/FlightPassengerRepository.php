<?php

namespace App\Repository;

use App\Entity\FlightPassenger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FlightPassenger|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlightPassenger|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlightPassenger[]    findAll()
 * @method FlightPassenger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightPassengerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FlightPassenger::class);
    }

    // /**
    //  * @return FlightPassenger[] Returns an array of FlightPassenger objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FlightPassenger
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
