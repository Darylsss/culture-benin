<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Créer l'utilisateur admin
        User::create([
            'name' => 'comlan',
            'email' => 'comlan@gmail.com',
            'password' => Hash::make('eneam123'), // Mot de passe : "password"
            'is_admin' => true,
        ]);

        // Optionnel : créer un utilisateur normal pour tester
        User::create([
            'name' => 'jolyne',
            'email' => 'jolyne@gmail.com',
            'password' => Hash::make('jolyne123'),
            'is_admin' => false,
        ]);

        $this->command->info('Utilisateur admin créé avec succès!');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Mot de passe: password');
    }
}