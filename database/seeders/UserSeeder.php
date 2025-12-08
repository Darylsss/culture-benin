<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Créer l'admin
        $admin = User::create([
            'name' => 'comlan',
            'email' => 'mauricee_comlan@uac.com',
            'password' => Hash::make('eneam123'),
        ]);

        $adminRole = Role::where('nom_role', 'administrateur')->first();
        $admin->roles()->attach($adminRole->id_role);

        // Créer le modérateur
        $moderator = User::create([
            'name' => 'kevin', 
            'email' => 'sossoukevinn@gmail.com',
            'password' => Hash::make('kevin123'),
        ]);

        $moderatorRole = Role::where('nom_role', 'moderateur')->first();
        $moderator->roles()->attach($moderatorRole->id_role);
    }
}