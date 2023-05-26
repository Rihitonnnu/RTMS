<?php

namespace App\Services;


class TimeBasedConversionService
{
    public function convertTimeToHour($startTime, $endTime)
    {
        $diffSeconds = $endTime->diffInSeconds($startTime);
        return round($diffSeconds / 3600, 2);
    }
}
