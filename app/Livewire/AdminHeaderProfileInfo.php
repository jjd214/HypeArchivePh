<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminHeaderProfileInfo extends Component
{
    public $admin;

    public $listeners = [
        'updateAdminHeaderProfileInfo' => '$refresh'
    ];

    public function mount() {
        if ( Auth::guard('admin')->check() ) {
            $this->admin = Admin::findOrFail(auth()->id());
        }
    }
    public function render()
    {
        return view('livewire.admin-header-profile-info');
    }
}
