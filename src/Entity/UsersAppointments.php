<?php

namespace App\Entity;

use App\Repository\UsersAppointmentsRepository;
use App\Trait\Entity\ActiveFields;
use App\Trait\Entity\DateFields;
use App\Trait\Entity\IdFields;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersAppointmentsRepository::class)]
class UsersAppointments
{
    use IdFields {
        initializeUuid as private initializeId;
    }

    use ActiveFields;

    use DateFields;

    #[ORM\ManyToOne(inversedBy: 'usersAppointments')]
    #[ORM\JoinColumn(nullable: false)]
    private Users $doctor;

    #[ORM\ManyToOne(inversedBy: 'usersAppointments')]
    #[ORM\JoinColumn(nullable: false)]
    private Users $patient;

    #[ORM\ManyToOne(inversedBy: 'usersAppointments')]
    #[ORM\JoinColumn(nullable: false)]
    private Appointments $appointment;

    #[ORM\Column]
    private bool $isAttended;

    public function getDoctor(): Users
    {
        return $this->doctor;
    }

    public function getPatient(): Users
    {
        return $this->patient;
    }

    public function getAppointment(): Appointments
    {
        return $this->appointment;
    }

    public function isAttended(): bool
    {
        return $this->isAttended;
    }
}
