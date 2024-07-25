<?php

namespace App\Controller;

use App\Interface\ListAppointmentsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1', name: 'api_')]
class AppointmentsController extends AbstractController
{
    #[Route('/list/appointments', name: 'appointments')]
    public function list(ListAppointmentsInterface $listAppointments): JsonResponse
    {
        $result = $listAppointments->handler();
        $status = $result["error"] ?? 200;
        return $this->json($result, $status);
    }
}
