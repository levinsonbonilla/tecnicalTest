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
        return $this->createQueryBuilder('appointment')
            ->select("
                appointment.id, 
                appointment.dateAppointment, 
                appointment.timeStart, 
                appointment.timeEnd, 
                speciality.name,
                appointment.active
            ")
            ->join("appointment.speciality", "speciality")
            ->andWhere('speciality.active = true')
            ->orderBy('speciality.name', 'ASC')
            ->getQuery()
            ->getResult("custom_appointments_hydrator");
    }
}
