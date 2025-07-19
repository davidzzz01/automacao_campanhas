<?php

namespace App\Helpers;

class CalculateCPA
{
    public static function from(int $views, int $conversions): float
    {
        if ($conversions === 0) {
            return INF;
        }

        return ($views * 0.01) / $conversions;
    }
}
