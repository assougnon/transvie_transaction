<?php

namespace App\Http\Controllers;

use App\Events\TransactionCreated;
use App\Models\Adherant;
use App\Models\Banque;
use App\Models\Transaction;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class TransactionController extends Controller
{
  public function __construct()
  {
    return $this->middleware('auth');
  }
  /**
   * @var SmsSender
   */

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

      $user_agence = Auth::user()->agence->id;
      $clients = Adherant::where('agence_id',$user_agence)->get()->count();
      $facture = Transaction::where('agence_id',$user_agence)->get()->count();
      $price = Transaction::all()->where('agence_id',$user_agence)->sum('montant');
        $cfa = $price   ;
      $impaye = Transaction::where('statut','Impayee')
        ->where(function ($query) use ($user_agence) {
          return $query->where('agence_id',$user_agence);
        })
        ->get()->sum('montant');




      return view('transactions.transaction',[
        'clients' =>$clients,
        'factures'=> $facture,
        'total'=>$cfa,
        'impayees' =>$impaye
      ]);
    }

    public function transctionManagement(Request $request)
    {

      $columns = [
        1 => 'numero',
        2 => 'adherant_prenom',
        3 => 'montant',
        4 => 'type',
        5 => 'statut',
        6 => 'note',
        7 => 'created_at',
      ];

      $search = [];
      $id = Auth::user()->agence->id;

      $totalData = Transaction::where('agence_id',$id)->count();

      $totalFiltered = $totalData;

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      if (empty($request->input('search.value'))) {
        $users = Transaction::where('agence_id',$id)->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
      } else {
        $search = $request->input('search.value');

        $users = Transaction::where('agence_id',$id)
          ->where(function ($query) use ($search) {
            return $query->orWhere('id', 'LIKE', "%{$search}%")
              ->orWhere('numero', 'LIKE', "%{$search}%")
              ->orWhere('type', 'LIKE', "%{$search}%")
              ->orWhere('statut', 'LIKE', "%{$search}%")
              ->orWhere('adherant_prenom', 'LIKE', "%{$search}%");
          })->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

        $totalFiltered = Transaction::where('agence_id',$id)
          ->orWhere('id', 'LIKE', "%{$search}%")
          ->orWhere('numero', 'LIKE', "%{$search}%")
          ->orWhere('type', 'LIKE', "%{$search}%")
          ->orWhere('statut', 'LIKE', "%{$search}%")
          ->orWhere('adherant_prenom', 'LIKE', "%{$search}%")
          ->count();
      }

      $data = [];

      if (!empty($users)) {
        // providing a dummy id instead of database ids
        $ids = $start;

        foreach ($users as $user) {
          $nestedData['numero'] = $user->numero;
          $nestedData['prenom'] = $user->adherant_prenom.' '.$user->adherant_nom;
          $nestedData['banque'] = $user->banque->nom;
          $nestedData['telephone'] = $user->telephone;
          $nestedData['montant'] = $user->montant;
          $nestedData['type'] = $user->type;
          $nestedData['statut'] = $user->statut;
          $nestedData['note'] = $user->note;
          $nestedData['created_at'] = $user->created_at;

          $data[] = $nestedData;
        }
      }

      if ($data) {
        return response()->json([
          'draw' => intval($request->input('draw')),
          'recordsTotal' => intval($totalData),
          'recordsFiltered' => intval($totalFiltered),
          'code' => 200,
          'data' => $data,
        ]);
      } else {
        return response()->json([
          'message' => 'Internal Server Error',
          'code' => 500,
          'data' => [],
        ]);
      }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $transaction_id = $this->lastID();
      $user_agence = Auth::user()->agence()->first();

      $adherents = Adherant::where('agence_id',$user_agence->id)->get();
      $paysID = $user_agence->pays()->first()->id;
      $banques = Banque::where('pays_id',$paysID)->get();




      return view('transactions.transaction-create',[
          'transaction_id'=>$transaction_id,
          'adherents' => $adherents,
        'banques'=>$banques
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'montant' => 'required',
        'adherant_id' => 'required',
        'banque_id' => 'required',
        'type' => 'required',


      ],
        [
          'nom.required' => 'Veuillez saisir un intitulé pour la banque',
          'pays_id.required' => 'Veuillez selectionner un pays',

        ]);

      $adherent = Adherant::where('id',$request->adherant_id)->first();

      $agence = Auth::user()->agence->id;
      $pays = Auth::user()->agence->pays->id;

      $transac = Transaction::create([
        'adherant_id' => $adherent->id,
        'numero'=>$this->lastID(),
        'montant'=>$request->montant,
        'type'=>$request->type,
        'note'=>$request->note,
        'banque_id'=>$request->banque_id,
        'adherant_prenom'=>$adherent->prenom,
        'adherant_nom'=>$adherent->nom,
        'adherant_entreprise'=>$adherent->nom_entreprise,
        'adherant_telephone'=>$adherent->telephone,
        'adherant_adresse'=>$adherent->adresse,
        'adherant_population'=>$adherent->population,
        'user_id'=>Auth::user()->id,
        'agence_id' => $agence,
        'pays_id' => $pays,
      ]);

      event( new TransactionCreated($transac));

      return redirect()->route('transaction-list');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function lastID()
    {
      $id = Transaction::orderBy('id','desc')->first();
      if ($id){

        return '0'.$id->id.now()->month.now()->year.auth()->user()->shortcode;
      }else{
        return '0'.$id.now()->month.now()->year.auth()->user()->shortcode;

      }
    }
}
