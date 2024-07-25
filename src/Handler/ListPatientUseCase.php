<?php

namespace App\Handler;

use App\Interface\ListPatientInterface;
use App\Repository\PatientDataRepository;

final class ListPatientUseCase implements ListPatientInterface
{
    public function __construct(
        private readonly PatientDataRepository $patientDataRepository
    )
    {
    }

    public function handler(): array
    {
        $elements = $this->patientDataRepository->getPatientList();
        $data = [
            "draw" => 1,
            "recordsTotal" => 2,
            "recordsFiltered" => 2,
            "data" => $elements
        ];
        return $data;
    }
}
