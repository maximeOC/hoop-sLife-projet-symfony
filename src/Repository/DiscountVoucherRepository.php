<?php

namespace App\Repository;

use App\Entity\DiscountVoucher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiscountVoucher>
 *
 * @method DiscountVoucher|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscountVoucher|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscountVoucher[]    findAll()
 * @method DiscountVoucher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountVoucherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscountVoucher::class);
    }

    public function save(DiscountVoucher $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DiscountVoucher $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DiscountVoucher[] Returns an array of DiscountVoucher objects
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

//    public function findOneBySomeField($value): ?DiscountVoucher
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
