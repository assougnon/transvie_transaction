<?php

namespace App\Livewire;

use App\Models\Pays;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserInscription extends Component
{
  public $title = '';

  public $content = '';
  public $user ;
  public $country ;
  public function mount(){
    $this->user = Auth::user();
    $this->country = Pays::all();
  }
  public function save(){

  }
    public function render()
    {
        return view('livewire.user-inscription',['user'=>Auth::user()])->extends('layouts.layoutMaster');
    }
}
