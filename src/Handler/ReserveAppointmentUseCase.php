<?php

namespace App\Handler;

use App\Argument\UsersAppointmentsArgument;
use App\Entity\Appointments;
use App\Entity\Users;
use App\Entity\UsersAppointments;
use App\Exception\GenericException;
use App\Interface\CustomeEntityManagerInterface;
use App\Interface\ReserveAppointmentInterface;
use App\Repository\AppointmentsRepository;
use App\Repository\UsersAppointmentsRepository;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\RequestStack;

final class ReserveAppointmentUseCase implements ReserveAppointmentInterface
{
    public function __construct(
        private readonly RequestStack $request,
        private readonly CustomeEntityManagerInterface $entityManager,
        private readonly UsersRepository $usersRepository,
        private readonly AppointmentsRepository $appointmentsRepository,
        private readonly UsersAppointmentsRepository $usersAppointmentsRepository
    ) {
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

            $this->addUsersAppointment($data);
            $result = [
                "message" => "Cita asignada correctamente"
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

    private function inactivateAppointment(Appointments $appointment): void
    {
        $appointment->inactivate();
        $this->entityManager->add($appointment, true);
    }

    private function addUsersAppointment(array $data): void
    {
        $appointment = $this->getAppointment($data);
        if (!$appointment->isActive()) {
            throw new GenericException("La cita ya fue asignada", 400);
        }

        $doctor = $this->getUser($data, "doctorId");
        $patient = $this->getUser($data, "patientId");

        $this->validateAppointmentCreate($appointment, $doctor, $patient);

        $argument = new UsersAppointmentsArgument(
            $doctor,
            $patient,
            $appointment
        );

        $entity = new UsersAppointments();
        $entity->add($argument);
        $this->entityManager->add($entity, false);
        $this->inactivateAppointment($appointment);
    }

    private function getUser(array $data, string $key): Users
    {
        if (!($id = $data[$key])) {
            throw new GenericException("No existe el $key", 400);
        }

        $user = $this->usersRepository->find($id);
        if (empty($user)) {
            throw new GenericException("No existe el $key", 400);
        }
        return $user;
    }

    private function getAppointment(array $data): Appointments
    {
        if (!($id = $data["appointmentId"])) {
            throw new GenericException("No existe el appointment", 400);
        }

        $appointment = $this->appointmentsRepository->find($id);
        if (empty($appointment)) {
            throw new GenericException("No existe el appointment", 400);
        }

        return $appointment;
    }

    public function validateAppointmentCreate(
        Appointments $appointment,
        Users $doctor,
        Users $patient
    ): void {
        $doctor = $this->usersAppointmentsRepository->findByAppointmentAndDoctorOrPatient(
            $appointment,
            $doctor
        );
        if (count($doctor) > 0) {
            throw new GenericException("El doctor ya cuenta con agenda en ese lapso de tiempo", 400);
        }

        $patient = $this->usersAppointmentsRepository->findByAppointmentAndDoctorOrPatient(
            $appointment,
            null,
            $patient
        );
        if (count($patient) > 0) {
            throw new GenericException("El paciente ya cuenta con agenda en ese lapso de tiempo", 400);
        }
    }
}
