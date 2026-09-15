<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@escuela.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Profesor Ejemplo',
            'email' => 'docente@escuela.com',
            'password' => Hash::make('password'),
            'role' => 'docente',
        ]);

        User::create([
            'name' => 'Tutor Ejemplo',
            'email' => 'tutor@escuela.com',
            'password' => Hash::make('password'),
            'role' => 'tutor',
        ]);
    }
}