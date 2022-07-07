<?php

namespace App\Repository;

use App\Entity\PlateauBeignet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlateauBeignet>
 *
 * @method PlateauBeignet|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlateauBeignet|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlateauBeignet[]    findAll()
 * @method PlateauBeignet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlateauBeignetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlateauBeignet::class);
    }

    public function add(PlateauBeignet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PlateauBeignet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PlateauBeignet[] Returns an array of PlateauBeignet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlateauBeignet
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
