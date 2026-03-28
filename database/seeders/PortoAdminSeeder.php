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
        User::query()->updateOrCreate(
            ['email' => 'winkytiopratama@gmail.com'],
            [
                'name' => 'wtp',
                'email_verified_at' => now(),
                'password' => Hash::make('winkyganteng'),
            ],
        );
    }
}
