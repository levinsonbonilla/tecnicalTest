<?php

namespace App\Entity;

use App\Argument\DoctorArgument;
use App\Repository\DoctorDataRepository;
use App\Trait\Entity\ActiveFields;
use App\Trait\Entity\DateFields;
use App\Trait\Entity\IdFields;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctorDataRepository::class)]
class DoctorData
{
    public const ROLE_DOCTOR = ["ROLE_DOCTOR"];
    use IdFields {
        initializeUuid as private initializeId;
    }

    use ActiveFields;

    use DateFields;

    #[ORM\Column(length: 50)]
    private string $professionalCard;

    #[ORM\Column(length: 50)]
    private string $professionalPhone;

    #[ORM\Column(length: 50)]
    private string $gender;

    #[ORM\ManyToOne(inversedBy: 'doctorData')]
    #[ORM\JoinColumn(nullable: false)]
    private Users $users;

    public function getProfessionalCard(): string
    {
        return $this->professionalCard;
    }

    public function getProfessionalPhone(): string
    {
        return $this->professionalPhone;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getUsers(): Users
    {
        return $this->users;
    }

    public function add(DoctorArgument $argument): DoctorData
    {
        $this->activate();
        $this->create();
        $this->professionalCard = $argument->getProfessionalCard();
        $this->professionalPhone = $argument->getProfessionalPhone();
        $this->gender = $argument->getGender();
        $this->users = $argument->getUsers();
        return $this;
    }
}
