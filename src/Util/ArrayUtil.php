<?php

namespace App\Util;

final class ArrayUtil
{
    /**
     * Retorna true si posee todas las llaves, de lo contrario retornara false
     * Returns true if it has all the keys, otherwise it will return false
     */
    public static function validateKeys(array $requireKeys, array $baseArray): bool 
    {
        return count(array_intersect_key(array_flip($requireKeys), $baseArray)) === count($requireKeys);
    }   
}
