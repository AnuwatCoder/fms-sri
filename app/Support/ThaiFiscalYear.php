<?php

namespace App\Support;

class ThaiFiscalYear
{
    public static function current(): int
    {
        $today = now();

        return $today->year + ($today->month >= 10 ? 544 : 543);
    }
}
