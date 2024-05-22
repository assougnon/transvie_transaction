<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('agences')->insert([
          'nom'=>'Direction Générale',
          'adresse'=> '2e  étage, Lot N°440 Zone de Captage/Hann Bel air BP: 47649 Dakar Liberté ',
          'telephone'=>' 33 824 33 44 / 33 824 33 45 ',
          'pays_id'=>1
        ]);
        DB::table('agences')->insert([
          'nom'=>'Agence Principale ',
          'adresse'=> 'Aux Allées Pape GUEYE en face de la Grande Mosquée de Dakar',
          'telephone'=>'33 868 51 69/ 33 943 45 08 ',
          'pays_id'=>1
        ]);
      DB::table('agences')->insert([
        'nom'=>'Agence Guédiawaye ',
        'adresse'=> 'Arrêt Dial MBAYE',
        'telephone'=>'33 837 33 41 ',
        'pays_id'=>1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence Gare Routière Des Baux Maraichers ',
        'adresse'=> 'Route de la roseraie, face marché central au poisson, Pikine ',
        'telephone'=>' 33 834 31 31',
        'pays_id'=>1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence de Thiès ',
        'adresse'=> 'Immeuble PA Avenue Léopold Sédar Senghor, Aiglon Thiès TH 11  ',
        'telephone'=>'33 951 14 62',
        'pays_id'=>1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence de Kaolack ',
        'adresse'=> 'Avenue John F. Kennedy Immeuble Serigne B. Mbacké Léona Kaolack ',
        'telephone'=>'33 942 29 42 ',
        'pays_id'=>1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence de Touba',
        'adresse'=> 'Résidence Mourtada Touba 28 2ème Étage, Immeuble Coris Bank en face Microcred ',
        'telephone'=>'33 978 36 02  ',
        'pays_id'=> 1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence de Saint Louis ',
        'adresse'=> 'Chambre de Commerce d’Industrie et d’Agriculture de Saint Louis, rue Augustin Henri Guilabert Saint Louis ',
        'telephone'=>'33 961 10 88',
        'pays_id'=> 1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence de Ziguinchor',
        'adresse'=> '1 er Étage, Appart Gauche Rue 122 Lot134 en fac Pharmacie Santhiaba Ziguinchor ',
        'telephone'=>'33 992 52 49 ',
        'pays_id'=>1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence de MBOUR',
        'adresse'=> 'Quartier Route de l’Hôpital, Immeuble CBAO, 1 er Étage ',
        'telephone'=>'33 957 87 98',
        'pays_id'=>1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence de Kaffrine',
        'adresse'=> 'Quartier Escale Kaffrine, Immeuble BHS',
        'telephone'=>'33 945 60 40',
        'pays_id'=>1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence de Tambacounda',
        'adresse'=> 'Tambacounda ',
        'telephone'=>'33 981 00 63',
        'pays_id'=>1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence de Fatick',
        'adresse'=> 'Fatick ',
        'telephone'=>'33 848 50 50',
        'pays_id'=>1
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence Côte d\'Ivoire',
        'adresse'=> 'Marcory Résidentiel, Lot 44, Îlot 11 ',
        'telephone'=>'+225 2721281669',
        'pays_id'=>2
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence Gambie',
        'adresse'=> 'Bijilo Senegambia Highway ',
        'telephone'=>'+2204461353',
        'pays_id'=>3
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence Togo',
        'adresse'=> 'Boulevard du 13 Janvier, Nyekonakpoe',
        'telephone'=>'+228 22 22 22 55',
        'pays_id'=>4
      ]);
      DB::table('agences')->insert([
        'nom'=>'Agence Benin',
        'adresse'=> 'Avenue Proche Saint Michel Quartier Gbedokpo',
        'telephone'=>'+229 20 21 48 99',
        'pays_id'=>5
      ]);
    }
}
