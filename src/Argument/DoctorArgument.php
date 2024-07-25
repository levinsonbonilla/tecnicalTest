<?php

namespace App\Argument;

use App\Entity\Users;
use App\Exception\GenericException;
use App\Util\ArrayUtil;

final class DoctorArgument
{
    private string $professionalCard;
    private string $professionalPhone;
    private string $gender;

    public function __construct(array $data, private readonly Users $users)
    {
        $requireKeys = ["professionalCard", "professionalPhone", "gender"];
        if (!ArrayUtil::validateKeys($requireKeys, $data)) {
            throw new GenericException(
                "ocurrio un error se esperaba: " . json_encode($requireKeys)
                    . " se recibio: " . json_encode($data),
                400
            );
        }
        $this->professionalCard = $data["professionalCard"];
        $this->professionalPhone = $data["professionalPhone"];
        $this->gender = $data["gender"];
    }

    public function getProfessionalCard(): string
    {
        return $this->professionalCard;
    }
    
    public function getProfessionalPhone(): string
    {
        return $this->professionalPhone;
    }
    
    public function getGender(): string
    {
        return $this->gender;
    }
    
    public function getUsers(): Users
    {
        return $this->users;
    }
    
}
