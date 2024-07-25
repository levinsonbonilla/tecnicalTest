<?php

namespace App\Argument;

use App\Entity\Eps;
use App\Entity\Users;

final class EpsUsersArgument
{
    public function __construct(private Eps $eps, private Users $users)
    {
    }

    public function getEps(): Eps
    {
        return $this->eps;
    }

    public function getUsers(): Users
    {
        return $this->users;
    }
    
}
