<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class GestionroleController extends Controller
{
  public function __construct()
  {
    return $this->middleware('auth');
  }
    public function index()
    {
     $users =User::all();
     $roles = Role::all();
     return view('gestionrole',[
       'users' => $users,
       'roles'=>$roles,
     ]);
    }
    public function create(Request $request)
    {
      $request->validate([
        'utilisateur' => 'required',
        'role' => 'required'
      ],[
        'utilisateur.required' => 'Veuillez sélectionner un utilisateur',
        'role.required' => 'Veuillez sélectionner un role'
      ]);
      $user = User::find($request->utilisateur);
      if($user->email === Auth::user()->email){
        return redirect()->back();
      }else
      {
        $user->syncRoles([]);

        $user->assignRole($request->role);
        $user->hasRole($request->role);
      }


      return redirect()->back();
    }
}
