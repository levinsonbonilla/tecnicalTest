<?php

namespace App\Entity;

use App\Repository\AppointmentsRepository;
use App\Trait\Entity\ActiveFields;
use App\Trait\Entity\DateFields;
use App\Trait\Entity\IdFields;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentsRepository::class)]
class Appointments
{
    use IdFields {
        initializeUuid as private initializeId;
    }

    use ActiveFields;

    use DateFields;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private \DateTimeImmutable $time_start;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private \DateTimeImmutable $time_end;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private \DateTimeImmutable $date_appointment;

    #[ORM\ManyToOne(inversedBy: 'appointments')]
    #[ORM\JoinColumn(nullable: false)]
    private Specialities $speciality;

    /**
     * @var Collection<int, UsersAppointments>
     */
    #[ORM\OneToMany(targetEntity: UsersAppointments::class, mappedBy: 'appointment')]
    private Collection $usersAppointments;

    public function __construct()
    {
        $this->usersAppointments = new ArrayCollection();
    }

    public function getTimeStart(): \DateTimeImmutable
    {
        return $this->time_start;
    }

    public function getTimeEnd(): \DateTimeImmutable
    {
        return $this->time_end;
    }

    public function getDateAppointment(): \DateTimeImmutable
    {
        return $this->date_appointment;
    }

    public function getSpeciality(): Specialities
    {
        return $this->speciality;
    }

    /**
     * @return Collection<int, UsersAppointments>
     */
    public function getUsersAppointments(): Collection
    {
        return $this->usersAppointments;
    }
}
