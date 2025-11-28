<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 1 Akun Admin
        User::create([
            'nama' => 'Super Admin',
            'email' => 'admin@wiflow.com',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'admin',
        ]);

        // Buat 1 Akun Teknisi
        User::create([
            'nama' => 'Budi Teknisi',
            'email' => 'budi@wiflow.com',
            'password' => Hash::make('password'),
            'role' => 'teknisi',
        ]);
    }
}