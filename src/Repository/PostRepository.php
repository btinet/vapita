<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }


    public function findByLikeSearch($value)
    {
        return $this->createQueryBuilder('p')
            ->orWhere('p.title LIKE :val')
            ->orWhere('p.metaTitle LIKE :val')
            ->orWhere('p.description LIKE :val')
            ->orWhere('p.metaDescription LIKE :val')
            ->orWhere('p.content LIKE :val')
            ->setParameter('val', "%$value%")
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getPreviousPost($id, $parent)
    {
        return $this->createQueryBuilder('p')
            ->select('p')

            ->andWhere('p.parent = :parent')
            ->andWhere('p.id < :id')
            ->setParameter(':id', $id)
            ->setParameter(':parent', $parent)
            ->orderBy('p.id', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function getNextPost($id, $parent)
    {
        return $this->createQueryBuilder('p')
            ->select('p')

            ->andWhere('p.parent = :parent')
            ->andWhere('p.id > :id')
            ->setParameter(':id', $id)
            ->setParameter(':parent', $parent)
            ->orderBy('p.id', 'ASC')
            ->setFirstResult(0)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
