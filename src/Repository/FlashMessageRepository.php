<?php

namespace App\Repository;

use App\Entity\FlashMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FlashMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlashMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlashMessage[]    findAll()
 * @method FlashMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlashMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FlashMessage::class);
    }

    // /**
    //  * @return FlashMessage[] Returns an array of FlashMessage objects
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
    public function findOneBySomeField($value): ?FlashMessage
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
