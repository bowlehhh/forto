<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminLoginSeeder extends Seeder
{
    private const NAME = 'Admin';
    private const EMAIL = 'winkytiopratama@gmail.com';
    private const PASSWORD = 'winkyganteng';

    /**
     * Seed the dashboard admin login account.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => self::EMAIL],
            [
                'name' => self::NAME,
                'email_verified_at' => now(),
                'password' => Hash::make(self::PASSWORD),
            ],
        );
    }
}
