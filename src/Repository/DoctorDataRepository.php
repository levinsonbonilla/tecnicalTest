<?php

namespace App\Repository;

use App\Entity\DoctorData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctorData>
 */
class DoctorDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctorData::class);
    }

    public function getDoctorList(): array
    {
        return $this->createQueryBuilder('doctor')
            ->select("
                doctor.id,
                users.email,
                users.name,
                users.lastName,
                doctor.professionalPhone,
                doctor.gender,
                doctor.professionalCard
            ")
            ->join('doctor.users', 'users')
            ->andWhere('doctor.active = true')
            ->andWhere('users.active = true')
            ->orderBy('users.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
