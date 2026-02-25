<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Affiche le login selon rôle
    public function showLogin($role){
        return view('login', compact('role'));
    }

    // Login
    public function login(Request $request, $role){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        $account = Account::where('email',$request->email)
                          ->where('role',$role)
                          ->first();

        if(!$account){
            return back()->withErrors(['email'=>'⚠️ Email ou rôle incorrect'])->withInput();
        }

        if(!Hash::check($request->password, $account->password)){
            return back()->withErrors(['password'=>'⚠️ Mot de passe incorrect'])->withInput();
        }

        Auth::login($account);
        $request->session()->regenerate();

        // Redirection selon rôle
        switch($role){
            case 'superviseur': return redirect()->route('dashboard.superviseur');
            case 'methodes': return redirect()->route('dashboard.methodes');
            case 'shift_leader': return redirect()->route('dashboard.shift');
        }
    }

    // Logout
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}