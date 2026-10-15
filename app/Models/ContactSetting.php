<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'description',
        'address',
        'phone',
        'email',
        'office_hours',
        'office_hours_note',
    ];

    public function getPhoneUriAttribute(): string
    {
        $digits = preg_replace('/\D+/', '', $this->phone) ?? '';

        if (str_starts_with($digits, '0')) {
            return '+66'.substr($digits, 1);
        }

        if (str_starts_with($digits, '66')) {
            return '+'.$digits;
        }

        return $digits === '' ? '' : '+'.$digits;
    }
}
