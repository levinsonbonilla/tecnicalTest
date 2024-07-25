<?php

namespace App\Controller;

use App\Interface\ListEpsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1', name: 'api_')]
class EpsController extends AbstractController
{
    #[Route('/list/eps', name: 'eps')]
    public function index( ListEpsInterface $listEps ): JsonResponse
    {
        $result = $listEps->handler();
        $status = $result["error"] ?? 200;
        return $this->json($result, $status);
    }
}
