<?php

namespace App\Http\Controllers;

use App\Models\Adherant;
use App\Models\Agence;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdherantController extends Controller
{
  public function __construct()
  {
   return $this->middleware('auth');
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $pays = Pays::all();

    return view('adherant.adherant-liste', ['pays' => $pays]);
  }

  public function adherant(Request $request)
  {
    $user = Auth::user();

    $columns = [
      1 => 'id',
      2 => 'prenom',
      3 => 'nom',
      4 => 'email',
      5 => 'telephone',
      6 => 'entreprise',
      7 => 'population',
      8 => 'agence',
    ];
    $search = [];
    $totalData = Adherant::where('agence_id',$user->agence->id)
      ->get()
    ->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');
    if (empty($request->input('search.value'))) {
      $adherants = Adherant::where('agence_id',$user->agence->id)
      ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');
      $adherants = Adherant::where('id', 'LIKE', "%{$search}")
        ->orWhere('prenom', 'LIKE', "%{$search}%")
        ->orWhere('telephone', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Adherant::where('id', 'LIKE', "%{$search}")
        ->orWhere('prenom', 'LIKE', "%{$search}%")
        ->orWhere('telephone', 'LIKE', "%{$search}%")
        ->count();
    }
    $data = [];
    if (!empty($adherants)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($adherants as $adherant) {
        $nestedData['id'] = $adherant->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['prenom'] = $adherant->prenom . ' ' . $adherant->nom;
        $nestedData['email'] = $adherant->email;
        $nestedData['telephone'] = $adherant->telephone;
        $nestedData['entreprise'] = $adherant->nom_entreprise;
        $nestedData['population'] = $adherant->population;
        $nestedData['agence'] = $adherant->agence->nom;


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
    return view('adherant.adherant-form');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {


    $validated = $request->validate([
      'prenom' => ['required', 'min:3', 'string', 'max:255'],
      'adresse' => ['string', 'max:255', 'nullable'],
      'nom' => ['required', 'min:3', 'string', 'max:255'],
      'entreprise' => ['min:3', 'string', 'max:255', 'nullable'],
      'telephone' => ['required', 'min:3', 'unique:adherants', 'string', 'max:255'],
      'population' => ['numeric', 'max:255'],
      'email' => ['email', 'unique:adherants', 'max:255', 'nullable'],
    ], [
      'email.unique' => 'Cette Adresse email existe Deja !',
      'email.email' => 'Veuillez fournir une adresse email valide !',
      'population.numeric' => 'Veuillez inscrire un chiffre, par ddfaut 1 !',
      'prenom.required' => 'Veuillez saisir un prenom  !',
      'nom.required' => 'Veuillez saisir un nom  !',
      'telephone.required' => 'Veuillez saisir un numéro  !',
      'prenom.min' => 'Le prenom doit contenir au moins 3 caractères  !',
      'nom.min' => 'Le nom doit contenir au moins 3 caractères !',
    ]);


    Adherant::updateOrCreate([
      'prenom' => $request->prenom,
      'nom' => $request->nom,
      'nom_entreprise' => $request->entreprise ? $request->entreprise : 'NC',
      'telephone' => $request->telephone2.$request->telephone,
      'email' => $request->email ? $request->email : 'NC',
      'population' => $request->population,
      'montant_attendu' => $request->montant,
      'adresse' => $request->adresse ? $request->adresse : 'NC',
      'agence_id' => Auth::user()->agence->id,
    ]);

    return redirect('/adherant');
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
    $where = ['id' => $id];

    $adherant = Adherant::where($where)->first();


    return response()->json($adherant);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    $adherantOldNumber = $request->oldnumber;

    if ($adherantOldNumber === $request->telephone) {
      Adherant::updateOrCreate(
        ['telephone' => $request->telephone],
        [
        'prenom' => $request->prenom_adh,
        'nom' => $request->nom,
        'nom_entreprise' => $request->entreprise ? $request->entreprise : 'NC',
        'email' => $request->email ? $request->email : 'NC',
        'population' => $request->population,
        'adresse' => $request->adresse ? $request->adresse : 'NC',
        'agence_id' => $request->agence,
          'telephone' => $request->telephone2.$request->telephone,
      ]);
      return response()->json('Réussie !');
    }else{
      Adherant::updateOrCreate(
        ['email' => $request->email],
        [
        'prenom' => $request->prenom_adh,
        'nom' => $request->nom,
        'nom_entreprise' => $request->entreprise ? $request->entreprise : 'NC',
        'telephone' => $request->telephone2.$request->telephone,
        'email' => $request->email ? $request->email : 'NC',
        'population' => $request->population,
        'adresse' => $request->adresse ? $request->adresse : 'NC',
        'agence_id' => $request->agence,
      ]);
      return response()->json('Réussie !');
    }

  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {

    $adherant = Adherant::where('id',$request->id)->delete();
  }

  public function selectPays(Request $request)
  {
    $agence = Agence::find($request->agenceID)->first();
    $paysID = $agence->pays->id;
    return response()->json(['pays' => $paysID]);
  }
}
