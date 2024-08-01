<?php

namespace App\Http\Controllers;

use App\Models\Banque;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use App\Traits\ImageUpload;
class BanqueController extends Controller
{
  public function __construct()
  {
   return $this->middleware('auth');
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $pays = Pays::all();

    return view('banques.banque-liste', ['pays' => $pays]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $pays = Pays::all();
    return view('banques.banque', ['pays' => $pays]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {


    $request->validate([
      'nom' => 'required',
      'pays_id' => 'required',
      'image_url' => 'required|mimes:jpeg,png,jpg,gif|max:2024',
    ],
      [
        'nom.required' => 'Veuillez saisir un intitulé pour la banque',
        'pays_id.required' => 'Veuillez selectionner un pays',
        'image_url.required' => 'Veuillez choisir le logo de la banque',
        'image_url.mimes' => 'le fichier doit être une image Ex: jpeg, png, jpg',
        'image_url.max' => 'la taille du fichier ne doit pas exceder 2Mo',
      ]);

    if ($image = $request->file('image_url')) {
      $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

      $image->move('images/banques', $imageName);

      Banque::create([
        'nom' => $request->nom,
        'telephone' => $request->telephone,
        'pays_id' => $request->pays_id,
        'image_url' => '/images/banques/' . $imageName,
        'adresse' => $request->adresse,
      ]);
    }


    return redirect()->back();
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $banque = Banque::where('id',$id)->first();
    $pays = Pays::all();
    return view('banques.banque-edit',[
      'pays'=>$pays,
      'banque'=>$banque
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $where = ['id' => $id];
    $banque = Banque::where('id', $where)->first();

    return response()->json($banque);
  }

  /**
   * Update the specified resource in storage.
   */
  public function updateBanque(Request $request)
  {
    $request->validate([
      'nom' => 'required',
      'pays_id' => 'required',
      'image_url' => 'mimes:jpeg,png,jpg,gif|max:2024',
    ],
      [
        'nom.required' => 'Veuillez saisir un intitulé pour la banque',
        'pays_id.required' => 'Veuillez selectionner un pays',
        'image_url.required' => 'Veuillez choisir le logo de la banque',
        'image_url.mimes' => 'le fichier doit être une image Ex: jpeg, png, jpg',
        'image_url.max' => 'la taille du fichier ne doit pas exceder 2Mo',
      ]);
    if ($request->oldimage && $request->image_url){

      File::delete(public_path($request->oldimage));

      $imageName = time() . '-' . uniqid() . '.' . $request->file('image_url')->getClientOriginalExtension();

      $request->file('image_url')->move('images/banques', $imageName);
      Banque::updateOrCreate(['id'=>$request->oldid],
        [
        'nom' => $request->nom,
        'telephone' => $request->telephone,
        'pays_id' => $request->pays_id,
        'image_url' => '/images/banques/' . $imageName,
        'adresse' => $request->adresse,
      ]);

    }else{
      Banque::updateOrCreate(['id'=>$request->oldid],
        [
          'nom' => $request->nom,
          'telephone' => $request->telephone,
          'pays_id' => $request->pays_id,
          'adresse' => $request->adresse,
        ]);
    }

    return redirect()->route('banques-liste');
  }



  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $banque = Banque::where('id', $id)->first();


   if ($banque->transactions->isEmpty() and $banque->depenses->isEmpty()) {

     if (File::exists(public_path($banque->image_url))) {
       File::delete(public_path($banque->image_url));
       $banque->delete();
     } else {
       $banque->delete();
     }
   }else {

     return response()->json(true);

   }



  }

  public function listeBanque(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'nom',
      3 => 'telephone',
      4 => 'adresse',
      5 => 'pays',

    ];

    $search = [];

    $totalData = Banque::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $banques = Banque::offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $banques = banque::where('id', 'LIKE', "%{$search}%")
        ->orWhere('nom', 'LIKE', "%{$search}%")
        ->orWhere('telephone', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Banque::where('id', 'LIKE', "%{$search}%")
        ->orWhere('nom', 'LIKE', "%{$search}%")
        ->orWhere('telephone', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($banques)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($banques as $banque) {
        $nestedData['id'] = $banque->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['nom'] = $banque->nom;
        $nestedData['telephone'] = $banque->telephone;
        $nestedData['pays'] = $banque->pays->nom;
        $nestedData['adresse'] = $banque->adresse;
        $nestedData['photo'] = $banque->image_url;


        $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
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
}
