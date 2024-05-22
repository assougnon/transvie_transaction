<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterBasic extends Controller
{
  public function index(Request $request)
  {


    $paysID = $request->id;


    $result = DB::table('agences')->where('pays_id','=',$paysID)->get();






    return response()->json($result);
  }
}
