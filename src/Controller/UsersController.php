<?php

namespace App\Controller;

use App\Interface\CreateDoctorInterface;
use App\Interface\CreatePatientInterface;
use App\Interface\ListDoctorInterface;
use App\Interface\ListPatientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1', name: 'api_')]
class UsersController extends AbstractController
{
    #[Route('/add/patient', name: 'pattient', methods: ["POST"])]
    public function addPatient(CreatePatientInterface $createPatient): JsonResponse
    {
        $result = $createPatient->handler();
        $status = $result["error"] ?? 200;
        return $this->json($result, $status);
    }

    #[Route('/add/doctor', name: 'doctor', methods: ["POST"])]
    public function addDoctor(CreateDoctorInterface $createDoctor): JsonResponse
    {
        $result = $createDoctor->handler();
        $status = $result["error"] ?? 200;
        return $this->json($result, $status);
    }

    #[Route('/list/patients', name: 'list_pattient', methods: ["GET"])]
    public function listPatient(ListPatientInterface $listPatient): JsonResponse
    {
        $result = $listPatient->handler();
        $status = $result["error"] ?? 200;
        return $this->json($result, $status);
    }

    #[Route('/list/doctors', name: 'list_doctor', methods: ["GET"])]
    public function listDoctor(ListDoctorInterface $listDoctor): JsonResponse
    {
        $result = $listDoctor->handler();
        $status = $result["error"] ?? 200;
        return $this->json($result, $status);
    }

}
