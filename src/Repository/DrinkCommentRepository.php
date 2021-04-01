<?php

namespace App\Repository;

use App\Entity\DrinkComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DrinkComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method DrinkComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method DrinkComment[]    findAll()
 * @method DrinkComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DrinkCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DrinkComment::class);
    }

    // /**
    //  * @return DrinkComment[] Returns an array of DrinkComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DrinkComment
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
