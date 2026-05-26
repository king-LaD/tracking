<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tracking.com'], // L'email qui servira d'identifiant
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'), // Modifie ça !
            ]
        );
    }
}