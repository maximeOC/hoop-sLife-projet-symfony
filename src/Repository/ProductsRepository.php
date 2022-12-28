<?php

namespace App\Repository;

use App\Data\PriceData;
use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{


    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Products::class);
        $this->paginator = $paginator;
    }

    public function save(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCategories($filters = null): array
    {
        $query = $this->createQueryBuilder('p');

        if($filters != null){
            $query->andWhere('p.categories IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getTotalProducts($filters = null ){
        $query = $this->createQueryBuilder('p')
            ->select('count(p)');

        if($filters != null){
            $query->andWhere('p.categories IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }
        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * Récupère les produits en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(PriceData $priceData): array
    {

        $query = $this
            ->createQueryBuilder('p');
//            ->select('c', 'p')
//            ->join('p.categories', 'c');

        if (!empty($priceData->min)) {
            $query = $query
                ->andWhere('p.price >= :min')
                ->setParameter('min', $priceData->min);
        }

        if (!empty($priceData->max)) {
            $query = $query
                ->andWhere('p.price <= :max')
                ->setParameter('max', $priceData->max);
        }
        return $query->getQuery()->getResult();
//        return $this->paginator->paginate(
//            $query,
//            1,
//            1
//        );

    }

    private function getSearchQuery(SearchData $search, $ignorePrice = false): QueryBuilder
    {
    }

}
