<?php 

namespace App\Argument;

use App\Entity\Users;
use App\Exception\GenericException;
use App\Util\ArrayUtil;

final class PatientArgument
{
    private string $address;
    private string $phone;
    private string $gender;
    private string $personalIdentification;

    public function __construct(array $data, private readonly Users $user)
    {
        $requireKeys = ["address", "phone", "gender", "personalIdentification"];
        if (!ArrayUtil::validateKeys($requireKeys, $data)) {
            throw new GenericException(
                "ocurrio un error se esperaba: " . json_encode($requireKeys)
                    . " se recibio: " . json_encode($data),
                400
            );
        }
        $this->address = $data["address"];
        $this->phone = $data["phone"];
        $this->gender = $data["gender"];
        $this->personalIdentification = $data["personalIdentification"];
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getPersonalIdentification(): string
    {
        return $this->personalIdentification;
    }

    public function getUsers(): Users
    {
        return $this->user;
    }    
}
