<?php

namespace App\Repository;

use App\Entity\Eps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Eps>
 */
class EpsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Eps::class);
    }

    public function getEpsList(): array
    {
        return $this->createQueryBuilder('eps')
            ->select("eps.id,eps.name")
            ->andWhere('eps.active = true')
            ->orderBy('eps.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
