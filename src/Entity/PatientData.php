<?php

namespace App\Entity;

use App\Argument\PatientArgument;
use App\Repository\PatientDataRepository;
use App\Trait\Entity\ActiveFields;
use App\Trait\Entity\DateFields;
use App\Trait\Entity\IdFields;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientDataRepository::class)]
class PatientData
{
    public const ROLE_PATIENT = ["ROLE_PATIENT"];

    use IdFields {
        initializeUuid as private initializeId;
    }

    use ActiveFields;

    use DateFields;

    #[ORM\Column(length: 255)]
    private string $address;

    #[ORM\Column(length: 30)]
    private string $phone;

    #[ORM\Column(length: 50)]
    private string $gender;

    #[ORM\Column(length: 50)]
    private string $personalIdentification;

    #[ORM\ManyToOne(inversedBy: 'patientData')]
    #[ORM\JoinColumn(nullable: false)]
    private Users $users;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getPersonalIdentification(): string
    {
        return $this->personalIdentification;
    }

    public function getUsers(): Users
    {
        return $this->users;
    }

    public function add(PatientArgument $argument): PatientData
    {
        $this->activate();
        $this->create();
        $this->address = $argument->getAddress();
        $this->phone = $argument->getPhone();
        $this->gender = $argument->getGender();
        $this->personalIdentification = $argument->getPersonalIdentification();
        $this->users = $argument->getUsers();
        return $this;
    }
}
