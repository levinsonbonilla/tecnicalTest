<?php

namespace App\Handler;

use App\Entity\Appointments;
use App\Exception\GenericException;
use App\Interface\AppointmentDataInterface;
use App\Repository\AppointmentsRepository;
use App\Repository\UsersAppointmentsRepository;
use Symfony\Component\HttpFoundation\RequestStack;

final class AppointmentDataUseCase implements AppointmentDataInterface
{

    public function __construct(
        private readonly UsersAppointmentsRepository $usersAppointmentsRepository,
        private readonly RequestStack $request,
        private readonly AppointmentsRepository $appointmentsRepository
    ) {
    }

    public function handler(): array
    {
        try {
            $request = $this->request->getCurrentRequest();

            $appointment = $this->getAppointment($request->get("appointmentId", null));
            $result = $this->usersAppointmentsRepository->findAppointmentData($appointment);
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

    private function getAppointment(?string $appointmentId = null): Appointments
    {
        if (empty($appointmentId)) {
            throw new GenericException("No existe el appointment", 400);
        }

        $appointment = $this->appointmentsRepository->find($appointmentId);
        if (empty($appointment)) {
            throw new GenericException("No existe el appointment", 400);
        }

        return $appointment;
    }
}
