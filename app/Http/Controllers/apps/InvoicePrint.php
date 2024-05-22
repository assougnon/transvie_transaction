<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Adherant;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;


use PDF;

class InvoicePrint extends Controller
{
  public function index(string $id)
  {
    $transaction = Transaction::where('numero',$id)->first();
    $agence = User::where('id',$transaction->user_id)->first()->agence()->first();
    $adherant =Adherant::where('id',$transaction->adherant_id)->first();
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.apps.app-invoice-print', [
      'pageConfigs' => $pageConfigs,
      'agence'=> $agence,
      'transaction'=> $transaction,
      'adherant'=> $adherant
    ]);

  }
  public function printInvoice(string $id)
  {
    $transaction = Transaction::where('numero',$id)->first();
    $agence = User::where('id',$transaction->user_id)->first()->agence()->first();
    $adherant =Adherant::where('id',$transaction->adherant_id)->first();
    $pageConfigs = ['myLayout' => 'blank'];
    $date = Carbon::now()->translatedFormat('d F Y');






    $data = [
      'pageConfigs' => $pageConfigs,
      'agence'=> $agence,
      'transaction'=> $transaction,
      'adherant'=> $adherant,
      'date'=>$date
    ];
/*
  return view('content.apps.app-invoice-print',[
      'pageConfigs' => $pageConfigs,
      'agence'=> $agence,
      'transaction'=> $transaction,
      'adherant'=> $adherant,
      'date'=>$date

    ]);*/

    $pdf = SnappyPdf::loadView('content.apps.app-invoice-print', $data);
    return $pdf->download('invoice345.pdf');



  }

}
