<?php

namespace App\Livewire;

use App\Http\Controllers\SmsSender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class UserProfil extends Component
{

  public $userinfo;

  public function testsms()
  {




  }

  public function mount()
  {

    $this->userinfo = Auth::user();

  }

  public function update()
  {


  }

  public function render()
  {
    return view('livewire.user-profil')->extends('layouts.layoutMaster');
  }
}
