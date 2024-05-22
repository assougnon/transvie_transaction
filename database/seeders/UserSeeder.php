<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('users')->insert([
        'name' => 'ASSOUGNON',
        'prenom' => 'Leon legrand Assougnon',
        'agence_id' => 1,
        'current_team_id' => 1,
        'poste' => 'Comptable',
        'adresse' => 'Ouest foire tally wally',
        'telephone' => '00221778117235',
        'email' => 'assougnonleon@gmail.com',
        'password' => Hash::make('machine213**'),
      ]);
    }
}
