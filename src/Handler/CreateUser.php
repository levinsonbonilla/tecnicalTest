<?php 

namespace App\Handler;

use App\Argument\EpsUsersArgument;
use App\Argument\UserArgument;
use App\Entity\Eps;
use App\Entity\EpsUsers;
use App\Entity\Users;
use App\Exception\GenericException;
use App\Interface\CustomeEntityManagerInterface;
use App\Repository\EpsRepository;
use App\Repository\UsersRepository;
use App\Util\ArrayUtil;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

abstract class CreateUser
{
    public function __construct(
        private readonly CustomeEntityManagerInterface $entityManager,
        private readonly EpsRepository $epsRepository,
        private readonly UserPasswordHasherInterface  $userPasswordHasher,
        private readonly UsersRepository $usersRepository
    ) {
    }

    protected function createUser(array $data): Users
    {
        if ( !($user = $this->usersRepository->findOneBy(["email"=>($data["email"]  ?? "")])) ) {
            $argument = new UserArgument($data);
            $user = new Users($this->userPasswordHasher);
            $user->add($argument);
            $this->entityManager->add($user);
        }
        
        return $user;
    }
    
    protected function createEpsUsers(Eps $eps, Users $users): void
    {
        $argument = new EpsUsersArgument($eps, $users);
        $epsUsers = new EpsUsers();
        $epsUsers->add($argument);
        $this->entityManager->add($epsUsers, true);
    }

    protected function getEps(array $data): Eps
    {
        if (!ArrayUtil::validateKeys(["epsId"], $data)) {
            throw new GenericException(
                "ocurrio un error se esperaba: epsId se recibio: " . json_encode($data),
                400
            );
        }

        $eps = $this->epsRepository->find($data["epsId"]);

        if (empty($eps)) {
            throw new GenericException("La EPS seleccionada esta inactiva o no ha sido creada", 400);            
        }

        return $eps;
    }
}