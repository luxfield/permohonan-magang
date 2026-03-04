<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user admin jika belum ada
        User::updateOrCreate(
            ['email' => 'admin@kejari.go.id'],
            [
                'name' => 'Administrator Kejari',
                'password' => Hash::make('password123'), // Password default
                'email_verified_at' => now(),
            ]
        );
    }
}