<?php

namespace App\Entity;

use App\Argument\EpsUsersArgument;
use App\Repository\EpsUsersRepository;
use App\Trait\Entity\ActiveFields;
use App\Trait\Entity\DateFields;
use App\Trait\Entity\IdFields;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpsUsersRepository::class)]
class EpsUsers
{
    use IdFields {
        initializeUuid as private initializeId;
    }

    use ActiveFields;

    use DateFields;

    #[ORM\ManyToOne(inversedBy: 'epsUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private Eps $eps;

    #[ORM\ManyToOne(inversedBy: 'epsUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private Users $users;

    public function getEps(): Eps
    {
        return $this->eps;
    }

    public function getUsers(): Users
    {
        return $this->users;
    }

    public function add(EpsUsersArgument $argument): EpsUsers
    {
        $this->activate();
        $this->create();
        $this->eps = $argument->getEps();
        $this->users = $argument->getUsers();
        return $this;
    }

}
