<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminNavBarComponent extends Component
{

    public function render()
    {
        return view('livewire.admin-nav-bar-component');
    }
}
