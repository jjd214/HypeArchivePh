<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin; 

class AdminController extends Controller
{
    public function loginHandler(Request $request){

        $credentials = $request->only('email', 'password');

        if(Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended(route('admin.home'));
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logoutHandler(Request $request) {
    
        Auth::guard('admin')->logout();
        session()->flash('fail', 'You are logged out!');
        return redirect()->route('admin.login');
        
    }

    public function profileView(Request $request) {
        $admin = null;

        if( Auth::guard('admin')->check() ) {
            $admin = Admin::findOrFail(auth()->id());
        }

        return view('admin.pages.profile', compact('admin')); 
    }
}
