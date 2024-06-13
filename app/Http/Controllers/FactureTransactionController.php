<?php

namespace App\Http\Controllers;

use App\Events\TransactionDeleted;
use App\Events\TransactionUpdated;
use App\Mail\TransactionRecu;
use App\Models\Adherant;
use App\Models\Banque;
use App\Models\Remise;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FactureTransactionController extends Controller
{
  public function index(string $id)
  {
    $transaction = Transaction::where('numero',$id)->first();
        $agence = User::where('id',$transaction->user_id)->first()->agence()->first();
        $adherant =Adherant::where('id',$transaction->adherant_id)->first();


    return view('content.apps.app-invoice-preview',[
      'agence'=> $agence,
      'transaction'=> $transaction,
      'adherant'=> $adherant
    ]);
  }
  public function edit(string $id)
  {
    $transaction = Transaction::where('numero',$id)->first();
    $agence = User::where('id',$transaction->user_id)->first()->agence()->first();
    $adherantActuel = Adherant::where('id',$transaction->adherant_id)->first();


    $user_agence = Auth::user()->agence()->first();
    $adherents = Adherant::where('agence_id',$user_agence->id)->get();
    $paysID = $user_agence->pays()->first()->id;
    $banques = Banque::where('pays_id',$paysID)->get();
    $remise = Remise::find($transaction->remise_id);



    return view('transactions.transaction-edit',[
      'agence'=> $agence,
      'transaction'=> $transaction,
      'adherents'=> $adherents,
      'banques'=>$banques,
      'adherentActuel' =>$adherantActuel,
      'remise' => $remise
    ]);
  }
  public function update(Request $request)
  {
    $old_transaction = Transaction::where('numero',$request->numero)->first();

    $request->validate([
      'montant' => 'required',
      'adherant_id' => 'required',
      'banque_id' => 'required',
      'type' => 'required',
      'statut' => 'required',


    ],
      [
        'nom.required' => 'Veuillez saisir un intitulé pour la banque',
        'pays_id.required' => 'Veuillez selectionner un pays',

      ]);
    $transac = Transaction::updateOrCreate(
        ['numero' => $request->numero],
      [
        'montant'=> $request->montant,
        'adherant_id'=> $request->adherant_id,
        'banque_id'=> $request->banque_id,
        'type'=> $request->type,
        'statut'=> $request->statut
      ]
    );
        $adherent = Adherant::where('id', $transac->adherant_id)->first();

    event(new TransactionUpdated($transac));
    if($old_transaction->statut !== $request->statut){
      if($transac->statut === 'Terminee'){
        $sms  = new SmsSender();

        $sms->sendSms($transac->adherant->telephone,'Hello TRANSVIE  vous informe que  votre paiement de '.$transac->montant.' CFA a été validé. Transaction numero :'.$transac->numero);

         Mail::to($adherent)->send(new TransactionRecu($transac));
      }
      if($transac->statut === 'Impayee'){
        $sms  = new SmsSender();
        $sms->sendSms($transac->adherant->telephone,'Hello TRANSVIE  vous informe que  votre paiement de '.$transac->montant.' CFA n\'a été validé. Transaction numero :'.$transac->numero.'Veuillez vous rapprocher de nos services');
      }
    }

    return redirect('/transaction');
  }

  public function delete(string $id)
  {
    $transaction = Transaction::where('numero',$id)->delete();
    event(new TransactionDeleted('transaction-deleted'));
    return Response()->json(
      ['message' => 'La Transaction  ',]
    );
  }
}
