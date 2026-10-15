<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = config('auth.administrator.email');

        if (is_string($adminEmail) && $adminEmail !== '') {
            $administrator = User::query()->firstOrNew([
                'email' => Str::lower(trim($adminEmail)),
            ]);

            $administrator->fill([
                'name' => config('auth.administrator.name', 'Portal Administrator'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]);

            if (! $administrator->exists) {
                $administrator->password = Hash::make(Str::random(64));
            }

            $administrator->save();
        }

        $this->call([
            SeoSettingSeeder::class,
            ContactSettingSeeder::class,
            PortalContentSeeder::class,
            AboutContentSeeder::class,
        ]);
    }
}
