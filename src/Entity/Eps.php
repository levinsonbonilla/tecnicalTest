<?php

namespace App\Entity;

use App\Argument\EpsArgument;
use App\Repository\EpsRepository;
use App\Trait\Entity\ActiveFields;
use App\Trait\Entity\DateFields;
use App\Trait\Entity\IdFields;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpsRepository::class)]
class Eps
{
    use IdFields {
        initializeUuid as private initializeId;
    }

    use ActiveFields;

    use DateFields;

    #[ORM\Column(length: 200)]
    private string $name;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    /**
     * @var Collection<int, EpsUsers>
     */
    #[ORM\OneToMany(targetEntity: EpsUsers::class, mappedBy: 'eps')]
    private Collection $epsUsers;

    public function __construct()
    {
        $this->epsUsers = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Collection<int, EpsUsers>
     */
    public function getEpsUsers(): Collection
    {
        return $this->epsUsers;
    }

    public function add(EpsArgument $argument): Eps
    {
        $this->activate();
        $this->create();
        $this->name = $argument->getName();
        $this->description = $argument->getDescription();
        return $this;
    }
}
