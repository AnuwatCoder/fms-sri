<?php

namespace Database\Seeders;

use App\Models\ContactSetting;
use Database\Seeders\Data\ContactSettingData;
use Illuminate\Database\Seeder;

class ContactSettingSeeder extends Seeder
{
    public function run(): void
    {
        ContactSetting::query()->firstOrCreate(
            ['id' => 1],
            ContactSettingData::defaults(),
        );
    }
}
