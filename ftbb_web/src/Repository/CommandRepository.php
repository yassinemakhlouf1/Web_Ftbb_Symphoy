<?php

namespace App\Repository;

use App\Entity\Command;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Command|null find($id, $lockMode = null, $lockVersion = null)
 * @method Command|null findOneBy(array $criteria, array $orderBy = null)
 * @method Command[]    findAll()
 * @method Command[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Command::class);
    }


    /**
     * @param $data
     * @return int|mixed|string
     */
    public function search($data){

        $query = $this->createQueryBuilder('c');
        if($data){
            $query->andWhere('c.dateCommand LIKE :data OR
                 c.status LIKE :data OR
                 c.totalPrice LIKE :data OR
                 c.commandId LIKE :data ')
                ->setParameter('data','%'.$data.'%');
        }
        return $query
            ->getQuery()
            ->getResult();
    }

    public function stat1()
    {
        $rawSql = "SELECT c.status,count(c.commandId) as nbdom FROM Command c group by c.status";

        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);

        return $stmt->fetchAll();
    }


}
