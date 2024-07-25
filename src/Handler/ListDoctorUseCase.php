<?php

namespace App\Handler;

use App\Interface\ListDoctorInterface;
use App\Repository\DoctorDataRepository;

final class ListDoctorUseCase implements ListDoctorInterface
{
    public function __construct(
        private readonly DoctorDataRepository $doctorDataRepository
    )
    {
    }

    public function handler(): array
    {
        $elements = $this->doctorDataRepository->getDoctorList();
        $data = [
            "draw" => 1,
            "recordsTotal" => 2,
            "recordsFiltered" => 2,
            "data" => $elements
        ];
        return $data;
    }
}
