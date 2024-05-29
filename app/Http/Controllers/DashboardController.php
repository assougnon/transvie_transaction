<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
 $populationSenegal = $this->populations('1');
 $populationBenin = $this->populations('5');
 $populationCote = $this->populations('2');
 $populationGambie = $this->populations('3');
 $populationTogo = $this->populations('4');


    //agence senegaal

    //get senegal monthly montant
    $montantSenegal = $this->montantAgence('1');
    //get cote d'ivoire monthly montant
    $montantCote = $this->montantAgence('2');
    //get montant benin
    $montantBenin = $this->montantAgence('5');


    return view('tableaudebord.dashboard', [
      'montantSenegal' => $montantSenegal,
      'montantCote' => $montantCote,
      'montantBenin' => $montantBenin,
      'populationSenegal'=>$populationSenegal,
      'populationBenin'=>$populationBenin,
      'populationCote'=>$populationCote,
      'populationGambie'=>$populationGambie,
      'populationTogo'=>$populationTogo,
    ]);
  }



  private function moisEncours($pays, $statut)
  {

    return $mont = DB::table('transactions')
      ->where('pays_id', $pays)
      ->where('statut', $statut)
      ->whereMonth('created_at', Carbon::now()->month)
      ->whereYear('created_at', Carbon::now()->year)
      ->get()->sum('montant');
  }

  public function donutData($pays)
  {

    $mois_fr = [
      1 => 'JAN',
      2 => 'FÉV',
      3 => 'MAR',
      4 => 'AVR',
      5 => 'MAI',
      6 => 'JUN',
      7 => 'JUL',
      8 => 'AOÛ',
      9 => 'SEP',
      10 => 'OCT',
      11 => 'NOV',
      12 => 'DÉC',
    ];
    $mois = $mois_fr[Carbon::now()->month];
    $impayee = $this->moisEncours($pays, 'Impayee');
    $encours = $this->moisEncours($pays, 'Encours');
    $terminee = $this->moisEncours($pays, 'Terminee');

    return response()->json([
      'impayee' => $impayee,
      'encours' => $encours,
      'terminee' => $terminee,
      'mois' => $mois
    ]);

  }

  public function transactionPays()
  {
    $montantSenegal = $this->montantAgence('1');
    //get cote d'ivoire monthly montant
    $montantCote = $this->montantAgence('2');
    //get montant benin
    $montantBenin = $this->montantAgence('5');
    //get montant togo
    $montantTogo = $this->montantAgence('4');
    //get montant Gambie
    $montantGambie = $this->montantAgence('3');
    return response()->json([
      'montantSenegal' => $montantSenegal,
      'montantCote' => $montantCote,
      'montantBenin' => $montantBenin,
      'montantGambie' => $montantGambie,
      'montantTogo' => $montantTogo
    ]);
  }

  public function statistiques($pays)
  {
    $transactions = $this->donneepays($pays, 'Encours');
    $transactions_terminee = $this->donneepays($pays, 'Terminee');
    $transactions_impayee = $this->donneepays($pays, 'Impayee');

    $mois_fr = [
      1 => 'JAN',
      2 => 'FÉV',
      3 => 'MAR',
      4 => 'AVR',
      5 => 'MAI',
      6 => 'JUN',
      7 => 'JUL',
      8 => 'AOÛ',
      9 => 'SEP',
      10 => 'OCT',
      11 => 'NOV',
      12 => 'DÉC',
    ];
    $transactions_fr = $transactions->map(function ($transaction) use ($mois_fr) {
      $transaction->mois = $mois_fr[$transaction->mois];
      return $transaction;
    });

    $labels = [];
    $data = [];
    $data_payee = [];
    $data_impayee = [];
    foreach ($transactions_fr as $transaction => $item) {
      $labels[$transaction] = $item->mois;
      $data[$transaction] = $item->total;
    }
    foreach ($transactions_terminee as $index => $item) {
      $data_payee[$index] = $item->total;
    }
    foreach ($transactions_impayee as $index => $item) {
      $data_impayee[$index] = $item->total;
    }

    return response()->json([
      'senegalMois' => $labels,
      'senegalMontant' => $data,
      'senegalPayee' => $data_payee,
      'senegalImpayee' => $data_impayee,
    ]);


  }

  private function donneepays($pays, $statut)
  {
    return Transaction::where('statut', $statut)
      ->where('pays_id', $pays)
      ->select(DB::raw('MONTH(created_at) as mois'), DB::raw('YEAR(created_at) as annee'), DB::raw('SUM(montant) as total'))
      ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
      ->orderBy('annee', 'desc')
      ->orderBy('mois', 'desc')
      ->get();
  }

  public function montantDeChaqueAgence()
  {
    //on recupère toutes les transactions en Terminée

    $transactionsTerminee = DB::table('transactions')
      ->where('pays_id', 1)
      ->where('statut', 'Terminee')
      ->whereMonth('created_at', Carbon::now()->month)
      ->whereYear('created_at', Carbon::now()->year)
      ->select('agence_id', DB::raw('SUM(montant) as total_amount'))
      ->groupBy('agence_id')
      ->get()
      ->keyBy('agence_id');

    //on recupère toutes les transactions en cours

    $transactionsEncours= DB::table('transactions')
      ->where('pays_id', 1)
      ->where('statut', 'Encours')
      ->whereMonth('created_at', Carbon::now()->month)
      ->whereYear('created_at', Carbon::now()->year)
      ->select('agence_id', DB::raw('SUM(montant) as total_amount'))
      ->groupBy('agence_id')
      ->get()
      ->keyBy('agence_id');

    $transactionsImpayees= DB::table('transactions')
      ->where('pays_id', 1)
      ->where('statut', 'Impayee')
      ->whereMonth('created_at', Carbon::now()->month)
      ->whereYear('created_at', Carbon::now()->year)
      ->select('agence_id', DB::raw('SUM(montant) as total_amount'))
      ->groupBy('agence_id')
      ->get()
      ->keyBy('agence_id');

// Récupérer toutes les agences
    $agencies = DB::table('agences')
      ->where('pays_id', '1')
      ->pluck('nom', 'id')
      ->toArray();

// Créer un tableau pour stocker les résultats finaux
    $montantTerminee = [];
    $montantEncours = [];
    $montantImpayee = [];
    $agences = [];

// Parcourir toutes les agences
    foreach ($agencies as $agencyId => $item) {
      // Si l'agence a des transactions, récupérer le montant total, sinon le mettre à zéro
      $totalAmountT = isset($transactionsTerminee[$agencyId]) ? $transactionsTerminee[$agencyId]->total_amount : 0;
      $totalAmountE = isset($transactionsEncours[$agencyId]) ? $transactionsEncours[$agencyId]->total_amount : 0 ;
      $totalAmountI = isset($transactionsImpayees[$agencyId]) ? $transactionsImpayees[$agencyId]->total_amount : 0 ;
      // Stocker le résultat dans le tableau final
      $montantTerminee[] = $totalAmountT;
      $montantEncours[] = $totalAmountE;
      $montantImpayee[] = $totalAmountI;
      $agences [] = $item;
    }
    return response()->json([
      'montantT' => $montantTerminee,
      'montantE' => $montantEncours,
      'montantI' => $montantImpayee,
      'agences' => $agences
    ]);
  }

  private function populations($pays)
  {
    $population = DB::table('transactions')
      ->where('pays_id', $pays)
      ->pluck('adherant_population')
      ->sum();
    return $population ? $population : 0 ;
  }

  private function montantAgence($pays)
  {

    return $mont = DB::table('transactions')
      ->where('pays_id', $pays)
      ->whereMonth('created_at', Carbon::now()->month)
      ->whereYear('created_at', Carbon::now()->year)
      ->get()->sum('montant');
  }

  public function banqueMontantTotal($ba)
  {

$tableu = [] ;
     $montant = Transaction::where('pays_id',$ba)
      ->whereMonth('created_at',Carbon::now()->month)
      ->whereYear('created_at',Carbon::now()->year)
       ->select('banque_id', DB::raw('SUM(montant) as total_amount'))
       ->groupBy('banque_id')
      ->get();
      foreach ($montant as $key => $item){
        $tableu[] = $item->banque->nom ;
        $tableu[] = $item->total_amont ;
        $tableu[] = $item->banque->image_url ;
      }

    return response()->json([
      'transaction' => $montant,


    ]);
  }
}
