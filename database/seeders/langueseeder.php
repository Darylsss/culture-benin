<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Langue;

class langueseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {
       
        
         Langue::create(['nom_langue'=>'Français','code_langue'=>'frrr','description'=>'langue de france']);
         Langue::create(['nom_langue'=>'Anglais-USA','code_langue'=>'En','description'=>'Anglais des Etats-Unis']);
          Langue::create(['nom_langue'=>'Anglais-UK','code_langue'=>'En-UK','description'=>'Anglais du Royaume-Uni']);
        //
    }
}
