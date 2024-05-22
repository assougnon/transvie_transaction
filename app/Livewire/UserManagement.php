<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserManagement extends Component
{
  public $search = '';
    public function render()
    {
        return view('livewire.user-management',[

          'users' => User::search($this->search),
        ])->extends('layouts.layoutMaster');
    }
}
