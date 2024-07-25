<?php

namespace App\Argument;

use App\Exception\GenericException;
use App\Util\ArrayUtil;

final class UserArgument
{
    private string $email;
    private array $roles;
    private string $password;
    private string $name;
    private string $lastName;

    public function __construct(array $data)
    {
        $requireKeys = ["email", "roles", "password", "name", "lastName"];
        if (!ArrayUtil::validateKeys($requireKeys, $data)) {
            throw new GenericException(
                "ocurrio un error se esperaba: " . json_encode($requireKeys)
                    . " se recibio: " . json_encode($data),
                400
            );
        }

        $this->email = $data["email"];
        $this->roles = $data["roles"];
        $this->password = $data["password"];
        $this->name = $data["name"];
        $this->lastName = $data["lastName"];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
