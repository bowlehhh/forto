<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortoAdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = (string) config('forto.admin.email');
        $name = (string) config('forto.admin.name', 'wtp');
        $password = (string) config('forto.admin.password');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'email_verified_at' => now(),
                'password' => Hash::make($password),
            ],
        );
    }
}
