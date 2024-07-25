<?php

namespace App\Repository;

use App\Entity\Appointments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appointments>
 */
class AppointmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointments::class);
    }

    public function getAppointmentsActives(): array
    {
        $now = new \DateTimeImmutable();
        return $this->createQueryBuilder('a')
            ->select("a.id, a.dateAppointment, a.timeStart, a.timeEnd ")
            ->andWhere('a.active = true')
            ->andWhere('a.dateAppointment >= :date')
            ->setParameter("date", $now)
            ->orderBy('a.dateAppointment', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
