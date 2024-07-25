<?php

namespace App\Repository;

use App\Entity\Appointments;
use App\Entity\Users;
use App\Entity\UsersAppointments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UsersAppointments>
 */
class UsersAppointmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersAppointments::class);
    }
    public function findAppointmentData(Appointments $appointment): array
    {
        $stringUuid = str_replace('-', '', $appointment->getId());
        return $this->createQueryBuilder('ua')
            ->select("
                ua.id,
                CONCAT(doc.name,' ',doc.lastName) as doctor,
                CONCAT(pat.name,' ',pat.lastName) as patient,
                ua.isAttended
            ")
            ->join("ua.appointment", "appointment")
            ->join("ua.doctor", "doc")
            ->join("ua.patient", "pat")
            ->andWhere('ua.appointment = :appointment')
            ->setParameter('appointment', hex2bin($stringUuid))
            ->getQuery()
            ->getResult();
    }

    public function findByAppointmentAndDoctorOrPatient(
        Appointments $appointment,
        ?Users $doctor = null,
        ?Users $patient = null
    ): array {
        $stringUuidAppointment = str_replace('-', '', $appointment->getId());

        $query = $this->createQueryBuilder('ua')
            ->join("ua.appointment", "appointment")
            ->andWhere('
                (ua.appointment = :appointment) OR
                (appointment.timeStart BETWEEN :startDate AND :endDate) OR
                (appointment.timeEnd BETWEEN :startDate AND :endDate)'
            )
            ->andWhere('appointment.dateAppointment = :dateAppointment')
            ->setParameter('appointment', hex2bin($stringUuidAppointment))
            ->setParameter('dateAppointment', $appointment->getDateAppointment())
            ->setParameter('startDate', $appointment->getTimeStart())
            ->setParameter('endDate', $appointment->getTimeEnd());
            

            if (!empty($doctor)) {
                $stringUuidDoctor = str_replace('-', '', $doctor->getId());
                $query 
                ->andWhere('ua.doctor = :doctor')
                ->setParameter('doctor', hex2bin($stringUuidDoctor));
            }else {
                $stringUuidPatient = str_replace('-', '', $patient->getId());
                $query
                ->andWhere('ua.patient = :patient')
                ->setParameter('patient', hex2bin($stringUuidPatient));                
            }

            return $query
            ->getQuery()
            ->getResult();
    }

    public function findByAppointmentAndPatient(
        Appointments $appointment,
        Users $patient
    ): array {
        $stringUuidAppointment = str_replace('-', '', $appointment->getId());
        $stringUuidPatient = str_replace('-', '', $patient->getId());

        return $this->createQueryBuilder('ua')
            ->andWhere('ua.appointment = :appointment')
            
            ->setParameter('appointment', hex2bin($stringUuidAppointment))
            
            ->getQuery()
            ->getResult();
    }
}
