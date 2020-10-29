<?php

namespace App\Repository;

use App\Entity\MainMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MainMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainMenu[]    findAll()
 * @method MainMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainMenu::class);
    }

    // /**
    //  * @return MainMenu[] Returns an array of MainMenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MainMenu
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
