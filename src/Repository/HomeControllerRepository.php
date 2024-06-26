<?php

namespace App\Repository;

use App\Entity\HomeController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HomeController>
 *
 * @method HomeController|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeController|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeController[]    findAll()
 * @method HomeController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeController::class);
    }

//    /**
//     * @return HomeController[] Returns an array of HomeController objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HomeController
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
