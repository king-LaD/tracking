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
            ['email' => 'admin@tracking.com'],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('admin123'), // Change ce mot de passe
                'is_admin' => true, // <--- C'est ici que tu forces le rôle admin
            ]
        );
    }
}