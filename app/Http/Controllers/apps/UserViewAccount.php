<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserViewAccount extends Controller
{
  public function index($user_id)
  {
    $user  = User::where('id',$user_id)->first();
    $total_transaction = Transaction::where('user_id',$user->id)->get()->count();

    return view('content.apps.app-user-view-account',[
      'user_infos' =>$user,
      'total_transaction'=>$total_transaction
    ]);
  }

  public function userTransactionManagement(Request $request)
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

    $totalData = Transaction::where('user_id',$request->user)->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $transactions = Transaction::where('user_id',$request->user)->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $transactions = Transaction::where('user_id',$request->user)
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

      $totalFiltered = Transaction::where('user_id',$request->user)
        ->orWhere('id', 'LIKE', "%{$search}%")
        ->orWhere('numero', 'LIKE', "%{$search}%")
        ->orWhere('type', 'LIKE', "%{$search}%")
        ->orWhere('statut', 'LIKE', "%{$search}%")
        ->orWhere('adherant_prenom', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($transactions)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($transactions as $user) {
        $nestedData['numero'] = $user->numero;
        $nestedData['prenom'] = $user->adherant_prenom.' '.$user->adherant_nom;
        $nestedData['montant'] = $user->montant;
        $nestedData['telephone'] = $user->telephone;
        $nestedData['type'] = $user->type;
        $nestedData['statut'] = $user->statut;
        $nestedData['note'] = $user->note;
        $nestedData['banque'] = $user->banque->nom;
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
}
