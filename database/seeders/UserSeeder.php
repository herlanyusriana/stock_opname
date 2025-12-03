<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => UserRole::ADMIN->value]
        );

        User::firstOrCreate(
            ['email' => 'keeper@example.com'],
            ['name' => 'Keeper', 'password' => Hash::make('password'), 'role' => UserRole::KEEPER->value]
        );

        User::firstOrCreate(
            ['email' => 'auditor@example.com'],
            ['name' => 'Auditor', 'password' => Hash::make('password'), 'role' => UserRole::AUDITOR->value]
        );

        User::firstOrCreate(
            ['email' => 'spv@example.com'],
            ['name' => 'Supervisor', 'password' => Hash::make('password'), 'role' => UserRole::SPV->value]
        );
    }
}
