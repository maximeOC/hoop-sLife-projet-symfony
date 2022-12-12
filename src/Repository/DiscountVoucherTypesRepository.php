<?php

namespace App\Repository;

use App\Entity\DiscountVoucherTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiscountVoucherTypes>
 *
 * @method DiscountVoucherTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscountVoucherTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscountVoucherTypes[]    findAll()
 * @method DiscountVoucherTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountVoucherTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscountVoucherTypes::class);
    }

    public function save(DiscountVoucherTypes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DiscountVoucherTypes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DiscountVoucherTypes[] Returns an array of DiscountVoucherTypes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DiscountVoucherTypes
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
