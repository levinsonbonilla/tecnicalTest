<?php

namespace App\Argument;

use App\Exception\GenericException;
use App\Util\ArrayUtil;

final class EpsArgument
{
    private string $name;
    private string $description;

    public function __construct(array $data)
    {
        $requireKeys = ["name", "description"];
        if (!ArrayUtil::validateKeys($requireKeys, $data)) {
            throw new GenericException(
                "ocurrio un error se esperaba: " . json_encode($requireKeys)
                    . " se recibio: " . json_encode($data),
                400
            );
        }

        $this->name = $data['name'];
        $this->description = $data['description'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
