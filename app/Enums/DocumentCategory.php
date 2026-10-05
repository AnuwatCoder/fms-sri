<?php

namespace App\Enums;

enum DocumentCategory: string
{
    case StrategicPlan = 'แผนและยุทธศาสตร์';
    case Budget = 'งบประมาณ';
    case Performance = 'ตัวชี้วัดและผลการดำเนินงาน';
    case Legal = 'กฎหมายและระเบียบ';
    case Manual = 'คู่มือ';
    case Form = 'แบบฟอร์ม';

    public function usesFiscalYear(): bool
    {
        return match ($this) {
            self::StrategicPlan, self::Budget, self::Performance => true,
            self::Legal, self::Manual, self::Form => false,
        };
    }

    /** @return array<string, string> */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $category): array => [$category->value => $category->value])
            ->all();
    }

    /** @return array<int, string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
