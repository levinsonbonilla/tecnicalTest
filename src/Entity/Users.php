<?php

namespace App\Entity;

use App\Argument\UserArgument;
use App\ArgumentHandler\UsersArgument;
use App\Repository\UsersRepository;
use App\Trait\Entity\ActiveFields;
use App\Trait\Entity\DateFields;
use App\Trait\Entity\IdFields;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    use IdFields {
        initializeUuid as private initializeId;
    }

    use ActiveFields;

    use DateFields;

    #[ORM\Column(length: 180)]
    private string $email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password;

    #[ORM\Column(length: 200)]
    private string $name;

    #[ORM\Column(length: 200)]
    private string $lastName;

    /**
     * @var Collection<int, EpsUsers>
     */
    #[ORM\OneToMany(targetEntity: EpsUsers::class, mappedBy: 'users')]
    private Collection $epsUsers;

    /**
     * @var Collection<int, UsersAppointments>
     */
    #[ORM\OneToMany(targetEntity: UsersAppointments::class, mappedBy: 'doctor')]
    private Collection $usersAppointments;

    /**
     * @var Collection<int, PatientData>
     */
    #[ORM\OneToMany(targetEntity: PatientData::class, mappedBy: 'users')]
    private Collection $patientData;

    /**
     * @var Collection<int, DoctorData>
     */
    #[ORM\OneToMany(targetEntity: DoctorData::class, mappedBy: 'users')]
    private Collection $doctorData;

    public function __construct(private readonly UserPasswordHasherInterface  $userPasswordHasher)
    {
        $this->epsUsers = new ArrayCollection();
        $this->usersAppointments = new ArrayCollection();
        $this->patientData = new ArrayCollection();
        $this->doctorData = new ArrayCollection();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return Collection<int, EpsUsers>
     */
    public function getEpsUsers(): Collection
    {
        return $this->epsUsers;
    }

    /**
     * @return Collection<int, UsersAppointments>
     */
    public function getUsersAppointments(): Collection
    {
        return $this->usersAppointments;
    }

    /**
     * @return Collection<int, PatientData>
     */
    public function getPatientData(): Collection
    {
        return $this->patientData;
    }

    /**
     * @return Collection<int, DoctorData>
     */
    public function getDoctorData(): Collection
    {
        return $this->doctorData;
    }

    public function add(UserArgument $argument): Users
    {
        $this->activate();
        $this->create();
        $this->email = $argument->getEmail();
        $this->roles = $argument->getRoles();
        $this->password = $this->userPasswordHasher->hashPassword($this, $argument->getPassword());
        $this->name = $argument->getName();
        $this->lastName = $argument->getLastName();
        return $this;
    }
}
