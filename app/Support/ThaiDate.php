<?php

namespace App\Support;

use Carbon\CarbonInterface;

class ThaiDate
{
    private const MONTHS = [
        1 => 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
        'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.',
    ];

    public static function shortMonth(CarbonInterface $date): string
    {
        return self::MONTHS[$date->month];
    }

    public static function date(CarbonInterface $date): string
    {
        return sprintf('%d %s %d', $date->day, self::shortMonth($date), $date->year + 543);
    }
}
