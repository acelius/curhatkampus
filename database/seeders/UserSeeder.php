<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Mahasiswa Dummy',
            'nim' => '123456789',
            'email' => 'mahasiswa@kampus.ac.id',
            'password' => Hash::make('password123'), // Passwordnya: password123
        ]);
    }
}