<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['nim' => '123456789'],
            [
                'admin_id' => null,
                'name' => 'Mahasiswa Demo',
                'email' => 'mahasiswa@curhatkampus.test',
                'password' => 'mahasiswa123',
                'role' => 'mahasiswa',
            ]
        );

        User::updateOrCreate(
            ['nim' => 'ADMIN001'],
            [
                'admin_id' => 'ADM001',
                'name' => 'Admin CurhatKampus',
                'email' => 'admin@curhatkampus.test',
                'password' => 'admin12345',
                'role' => 'admin',
            ]
        );
    }
}