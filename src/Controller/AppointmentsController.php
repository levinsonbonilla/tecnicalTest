<?php

namespace App\Controller;

use App\Interface\AppointmentDataInterface;
use App\Interface\ListAppointmentsInterface;
use App\Interface\ReserveAppointmentInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1', name: 'api_')]
class AppointmentsController extends AbstractController
{
    #[Route('/list/appointments', name: 'appointments')]
    public function list(
        ListAppointmentsInterface $listAppointments
    ): JsonResponse {
        $result = $listAppointments->handler();
        $status = $result["error"] ?? 200;
        return $this->json($result, $status);
    }

    #[Route('/reserve/appointment', name: 'reserve_appointment')]
    public function reserve(
        ReserveAppointmentInterface $reserveAppointment
    ): JsonResponse {
        $result = $reserveAppointment->handler();
        $status = $result["error"] ?? 200;
        return $this->json($result, $status);
    }

    #[Route('/data/appointment', name: 'data_appointment')]
    public function data(
        AppointmentDataInterface $appointmentData
    ): JsonResponse {
        $result = $appointmentData->handler();
        $status = $result["error"] ?? 200;
        return $this->json($result, $status);
    }
}
