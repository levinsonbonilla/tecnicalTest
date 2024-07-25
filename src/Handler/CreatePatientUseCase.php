<?php

namespace App\Handler;

use App\Argument\EpsUsersArgument;
use App\Argument\PatientArgument;
use App\Argument\UserArgument;
use App\Entity\Eps;
use App\Entity\EpsUsers;
use App\Entity\PatientData;
use App\Entity\Users;
use App\Exception\GenericException;
use App\Interface\CreatePatientInterface;
use App\Interface\CustomeEntityManagerInterface;
use App\Repository\EpsRepository;
use App\Repository\UsersRepository;
use App\Util\ArrayUtil;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CreatePatientUseCase extends CreateUser implements CreatePatientInterface
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
            $data["roles"] = PatientData::ROLE_PATIENT;
            $user = $this->createUser($data);
            $this->createPatient($data, $user);
            $this->createEpsUsers(
                $this->getEps($data),
                $user
            );

            $result = [
                "message" => "Paciente creado exitosamente"
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

    private function createPatient(array $data, Users $user): void
    {
        if (count($user->getPatientData()) > 0) {
            throw new GenericException("Paciente existente", 400);
        }

        $argument = new PatientArgument($data, $user);
        $patient = new PatientData();
        $patient->add($argument);
        $this->entityManager->add($patient);
    }
}
