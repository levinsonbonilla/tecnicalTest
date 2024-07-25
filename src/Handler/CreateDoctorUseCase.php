<?php

namespace App\Handler;

use App\Argument\DoctorArgument;
use App\Entity\DoctorData;
use App\Entity\Users;
use App\Exception\GenericException;
use App\Interface\CreateDoctorInterface;
use App\Interface\CustomeEntityManagerInterface;
use App\Repository\EpsRepository;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CreateDoctorUseCase extends CreateUser implements CreateDoctorInterface
{
    public function __construct(
        private readonly RequestStack $request,
        private readonly CustomeEntityManagerInterface $entityManager,
        EpsRepository $epsRepository,
        UserPasswordHasherInterface  $userPasswordHasher,
        UsersRepository $usersRepository
    ) {
        parent::__construct($entityManager, $epsRepository, $userPasswordHasher, $usersRepository);
    }

    public function handler(): array
    {
        $result = [];
        try {
            $request = $this->request->getCurrentRequest();
            $json = $request->getContent();
            if (!json_validate($json)) {
                throw new GenericException("Error Processing Request", 400);
            }

            $data = json_decode($json, true);
            $data["roles"] = DoctorData::ROLE_DOCTOR;
            $user = $this->createUser($data);
            $this->createDoctor($data, $user);
            $this->createEpsUsers(
                $this->getEps($data),
                $user
            );

            $result = [
                "message" => "Doctor creado exitosamente"
            ];
        } catch (GenericException $ge) {
            $result = [
                "message" => $ge->getMessage(),
                "error" => 400
            ];
        } catch (\Throwable $th) {
            $result = [
                "message" => "Ocurrio un error inesperado",
                "error" => 500
            ];
        }

        return $result;
    }

    private function createDoctor(array $data, Users $user): void
    {
        if (count($user->getDoctorData()) > 0) {
            throw new GenericException("Doctor existente", 400);
        }

        $argument = new DoctorArgument($data, $user);
        $doctor = new DoctorData();
        $doctor->add($argument);
        $this->entityManager->add($doctor);
    }
}
