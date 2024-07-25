<?php

namespace App\Util;

final class StringUtil
{

    public static function convertToFormatUuid(string $uuidString): ?string
    {
        $uuidString = substr($uuidString, 0, 8) . '-' .
            substr($uuidString, 8, 4) . '-' .
            substr($uuidString, 12, 4) . '-' .
            substr($uuidString, 16, 4) . '-' .
            substr($uuidString, 20);

        return $uuidString;
    }
}
