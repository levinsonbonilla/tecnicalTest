<?php

namespace App\Hydrator;

use App\Util\StringUtil;
use Doctrine\ORM\Internal\Hydration\AbstractHydrator;

class CustomeAppointmentsHydrator extends AbstractHydrator
{
    final public const CUSTOME_PAY_PARTNERS_HYDRATOR = 'custom_appointments_hydrator';

    protected function hydrateAllData(): mixed
    {
        $resultSetReturn = [];
        $result =  $this->stmt->fetchAllAssociative();

        foreach ($result as $principalKey => $data) {
            foreach ($data as $key => $row) {
                $cacheKeyInfo = self::hydrateColumnInfo($key);
                if ($cacheKeyInfo['fieldName'] === 'id') {
                    $row = StringUtil::convertToFormatUuid(bin2hex($row));
                }
                $resultSetReturn[$principalKey][$cacheKeyInfo['fieldName']] = $row;
            }
        }
        return $resultSetReturn;
    }
}
