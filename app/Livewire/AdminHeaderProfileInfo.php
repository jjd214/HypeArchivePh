<?php

namespace App\Livewire;

use Livewire\Component;

// Include Admin Model
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminHeaderProfileInfo extends Component
{
    public $admin;

    public function mount() {
        if( Auth::guard('admin')->check() ) {
            $this->admin = Admin::findOrFail(auth()->id());
        }
    }
    public function render()
    {
        return view('livewire.admin-header-profile-info');
    }
}

