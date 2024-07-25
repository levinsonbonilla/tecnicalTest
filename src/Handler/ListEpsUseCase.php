<?php

namespace App\Handler;

use App\Interface\ListEpsInterface;
use App\Repository\EpsRepository;

final class ListEpsUseCase implements ListEpsInterface
{
    public function __construct( 
        private readonly EpsRepository $epsRepository
    )
    {
    }

    public function handler(): array
    {
        try {
            $result = $this->epsRepository->getEpsList();
        } catch (\Throwable $th) {
            $result = [
                "message" => "Ocurrio un error inesperado",
                "error" => 500
            ];
        }
        return $result;
    }
    
}
