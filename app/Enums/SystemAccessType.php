<?php

namespace App\Enums;

enum SystemAccessType: string
{
    case External = 'external';
    case Vpn = 'vpn';

    public function label(): string
    {
        return match ($this) {
            self::External => 'ภายนอก',
            self::Vpn => 'ภายใน VPN',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::External => 'bi-globe2',
            self::Vpn => 'bi-shield-lock-fill',
        };
    }

    /** @return array<string, string> */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type): array => [$type->value => $type->label()])
            ->all();
    }
}
