<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Pays;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;

class CreateUserController extends Controller
{
  use PasswordValidationRules;

   public function __construct()
   {
     $this->middleware('auth');
   }

  public function index()
  {

    return view('auth.register', ['country' => Pays::all()]);
  }

  public function store(Request $input)
  {
    Validator::make($input->all(), [
      'prenom' => ['required', 'string', 'max:255'],

      'pays' => ['required', 'string', 'max:255'],
      'name' => ['required', 'string', 'max:255'],
      'poste' => ['required', 'string', 'max:255'],
      'adresse' => ['required', 'string', 'max:255'],
      'telephone' => ['required', 'string', 'max:255'],
      'agence' => ['required','numeric'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => $this->passwordRules(),
      'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
    ],
      [
        'pays.required' => 'Veillez choisir un pays',
        'prenom.required' => 'Veillez saisir un prenom',
        'telephone.required' => 'Veillez saisir un numéro de téléphone',
        'poste.required' => 'Veillez saisir un poste',
        'name.required' => 'Veillez saisir un nom',
        'email.unique' => 'Adresse email déjà utilisée',
        'pays.required' => 'Selectionnez un pays',
        'password.required' => 'Un mot de passe est requis ',
        'password.mixed' => 'Veuillez fournir une combinaison de lettre et de chiffre ',
        'password.min' => 'Un minimum de caractère 8 est requis',
        'password.symbols' => 'le mot de passe doit contenir un symbole  *#@...',
        'password.confirmed' => 'Veuillez confirmer le mot de passe',
      ]
    )->validate();

     DB::transaction(function () use ($input) {
      return tap(User::create([
        'prenom' => $input['prenom'],
        'poste' => $input['poste'],
        'name' => $input['name'],
        'telephone' => $input['telephone'],
        'agence_id' => $input['agence'],
        'adresse' => $input['adresse'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
      ]), function (User $user) {
        $this->createTeam($user);


      });

    });

    return redirect('/inscription')->with('status', 'L\'utilisateur a été crée ');
  }

  protected function createTeam(User $user): void
  {
    $user->ownedTeams()->save(Team::forceCreate([
      'user_id' => $user->id,
      'name' => explode(' ', $user->name, 2)[0] . "'s Team",
      'personal_team' => true,
    ]));
  }

}
