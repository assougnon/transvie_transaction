<?php

namespace App\Http\Controllers;

use App\Models\Remise;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class RemiseController extends Controller
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
      $agence = Auth::user()->agence->id;


      $transac = Transaction::where('agence_id',$agence)
      ->where('remise_id','!=',null)
      ->select(['remise_id'])
      ->groupBy('remise_id')
      ->get();







      $data = [];


      foreach ($transac as $key => $transaction){

        $nestedData['id'] = $transaction->remise->id;
        $nestedData['image_url'] = $transaction->remise->image_url;


        $data[] = $nestedData ;
      }



        return view('remise.remiseListe',['datas'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $user_agence = Auth::user()->agence->id;
      $transaction = Transaction::where('agence_id',$user_agence)
        ->where('statut','Encours')
        ->where('type','Cheque')
        ->where('remise_id',null)->get();


        return view('remise.remiseCreate',[
          'transaction' => $transaction,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


     $request->validate([
        'remisePhoto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
      ],[
        'remisePhoto.required' => 'Veuillez selectionner une image'
     ]);


      $remise = new Remise();

      $imageName =  $imageName = time().'.'.$request->remisePhoto->extension();
      $request->remisePhoto->move(public_path('images'), $imageName);
      $remise->image_url = 'images/'.$imageName ;
      $remise->save();

      foreach ($request->remise as $transaction){
        $transac = Transaction::find($transaction);
        $transac->remise_id = $remise->id;
        $transac->save();
      }


      return redirect('remise');


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
        //
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

      Transaction::where('remise_id', $id)
        ->update(['remise_id' => null,
          'statut' => 'Encours'
          ]);
      $image = Remise::find($id);
      $image_path = $image->image_url;  // Value is not URL but directory file path
      if(File::exists($image_path)) {
        File::delete($image_path);
      }
      $image->delete();
      return redirect()->back();
    }

    public function liste(Request $request)
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

      $totalData = Transaction::where('agence_id',$id)->where('remise_id','!=',null)->count();

      $totalFiltered = $totalData;

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      if (empty($request->input('search.value'))) {
        $users = Transaction::where('agence_id',$id)
          ->where('remise_id','!=',null)
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
      } else {
        $search = $request->input('search.value');

        $users = Transaction::where('agence_id',$id)
          ->where('remise_id','!=',null)
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
          $nestedData['remise'] = $user->remise->image_url;
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

    public function imageRemise(Request $request){

    }
}
