<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminPassword = env('ADMIN_PASSWORD');

        if ($adminPassword || app()->environment('testing')) {
            User::query()->updateOrCreate(
                ['email' => env('ADMIN_EMAIL', 'admin@fms.local')],
                [
                    'name' => env('ADMIN_NAME', 'Portal Administrator'),
                    'password' => Hash::make($adminPassword ?: 'password'),
                    'email_verified_at' => now(),
                    'is_admin' => true,
                ],
            );
        }

        $this->call([
            PortalContentSeeder::class,
            AboutContentSeeder::class,
        ]);
    }
}
