<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
    /**
     * @param $name
     * @return int|mixed|string
     */
    function searchName($name){
        return $this->createQueryBuilder('p')
            ->where('.name LIKE :name')
            ->setParameter('name','%' . $name . '%')
            ->getQuery()->getResult();
    }

    /**
     * @param $data
     * @return int|mixed|string
     */
    public function search($data){

        $query = $this->createQueryBuilder('p');
        if($data){
            $query->andWhere('p.refProduct LIKE :data OR
                 p.category LIKE :data OR
                 p.name LIKE :data  ')
                ->setParameter('data','%'.$data.'%');
        }
        return $query
            ->getQuery()
            ->getResult();
    }

    public function stat1()
    {
        $rawSql = "SELECT p.category,count(p.refProduct) as nbdom FROM Product p group by p.category";

        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }


}
