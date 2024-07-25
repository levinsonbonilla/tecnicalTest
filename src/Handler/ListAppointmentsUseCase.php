<?php

namespace App\Handler;

use App\Interface\ListAppointmentsInterface;
use App\Repository\AppointmentsRepository;

final class ListAppointmentsUseCase implements ListAppointmentsInterface
{
    public function __construct(
        private readonly AppointmentsRepository $appointmentsRepository
    )
    {
    }

    public function handler(): array
    {
        try {
            $result = $this->appointmentsRepository->getAppointmentsActives();
        } catch (\Throwable $th) {
            $result = [
                "message" => "Ocurrio un error inesperado",
                "error" => 500
            ];
        }
        return $result;
    }
}
