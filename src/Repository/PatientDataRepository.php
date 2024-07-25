<?php

namespace App\Repository;

use App\Entity\PatientData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PatientData>
 */
class PatientDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatientData::class);
    }

    public function getPatientList(): array
    {
        return $this->createQueryBuilder('patient')
            ->select("
                patient.id,
                users.email,
                users.name,
                users.lastName,
                patient.address,
                patient.phone,
                patient.gender,
                patient.personalIdentification
            ")
            ->join('patient.users', 'users')
            ->andWhere('patient.active = true')
            ->andWhere('users.active = true')
            ->orderBy('users.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
