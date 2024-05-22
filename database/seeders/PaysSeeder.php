<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pays')->insert(['nom'=>'Sénégal']);
        DB::table('pays')->insert(['nom'=>'Cote d\'Ivoire']);
        DB::table('pays')->insert(['nom'=>'Gambie']);
        DB::table('pays')->insert(['nom'=>'Togo']);
        DB::table('pays')->insert(['nom'=>'Benin']);
    }
}
