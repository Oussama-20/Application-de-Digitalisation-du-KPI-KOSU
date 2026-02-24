<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class AuthController extends Controller
{
    // Afficher login selon role
    public function showLogin($role)
    {
        return view('login', compact('role'));
    }

    // Login
    public function login(Request $request, $role)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $account = Account::where('email', trim($request->email))
                          ->where('role', $role)
                          ->first();

        if(!$account){
            return back()->with('error','ROLE OU EMAIL NON TROUVÉ');
        }

        if(!Hash::check($request->password, $account->password)){
            return back()->with('error','MOT DE PASSE INCORRECT');
        }

        session([
            'account_id' => $account->id,
            'role' => $account->role
        ]);

        return redirect()->route('dashboard', ['role'=>$role]);
    }
    public function loginPerform(Request $request, $role)
{
    // Validation basique
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Cherche l'utilisateur par email
    $user = User::where('email', $request->email)->first();

    // Si l'utilisateur n'existe pas → erreur email/mot de passe
    if (!$user) {
        return back()->withErrors(['email' => 'Email ou mot de passe incorrect'])->withInput();
    }

    // Si le rôle ne correspond pas → erreur rôle
    if ($user->role !== $role) {
        return back()->withErrors(['role' => '⚠️ Le profil sélectionné ne correspond pas à votre compte'])->withInput();
    }

    // Vérifie le mot de passe
    if (!\Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Email ou mot de passe incorrect'])->withInput();
    }

    // Authentifie
    Auth::login($user, $request->has('remember'));

    $request->session()->regenerate();

    // Redirection vers dashboard
    return redirect()->route('dashboard', $role);
}
    // Dashboard
    public function dashboard($role)
    {
        if(!session()->has('role') || session('role') != $role){
            abort(403,'Accès non autorisé');
        }

        return view('dashboard', compact('role')); 
    }

    // Logout
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}