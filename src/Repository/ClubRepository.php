<?php

namespace App\Repository;

use App\Entity\club;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method club|null find($id, $lockMode = null, $lockVersion = null)
 * @method club|null findOneBy(array $criteria, array $orderBy = null)
 * @method club[]    findAll()
 * @method club[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, club::class);
    }



    public function findByDates($start,$end)
    {
        var_dump($start,$end);
       $queryBuilder =  $this->createQueryBuilder('c')
                            ->join('c.season','s');
                     if ($start) {
                         $queryBuilder->where('s.startDate = :start')
                             ->setParameter('start', $start);
                     }
                     if ($end) {
                         $queryBuilder->andWhere('s.endDate = :end')
                                      ->setParameter('end', $end);
                     }
        $queryBuilder->getQuery()->getResult();


    }

}
