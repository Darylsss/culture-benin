<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class roleseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['nom_role'=>'Administrateur']);
         Role::create(['nom_role'=>'Modérateur']);
          Role::create(['nom_role'=>'Auteur']);
        //
    }
}
