<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminProfileTabs extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab'];
    public $name, $email, $username, $admin_id;

    public function selectTab($tab) {
        $this->tab = $tab;
    }

    public function mount() {
        $this->tab = request()->tab ? request()->tab : $this->tabname;

        if( Auth::guard('admin')->check() ) {
            $admin = Admin::findOrFail(auth()->id());

            $this->name = $admin->name;
            $this->email = $admin->email;
            $this->username = $admin->username;
            $this->admin_id = $admin->id;

        }
    }

    public function updateAdminPersonalDetails() {
        $this->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:admins,email,'.$this->admin_id,
            'username' => 'required|min:3|unique:admins,username,'.$this->username
        ]);

        Admin::find($this->admin_id)->update([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username
        ]);

        echo '<script>alert("updated successfully")</script>';
    }

    public function render()
    {
        return view('livewire.admin-profile-tabs');
    }
}
