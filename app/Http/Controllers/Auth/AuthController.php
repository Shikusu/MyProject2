<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Gère la connexion de l'utilisateur.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Gestion du "Se souvenir de moi"

        if (Auth::attempt($credentials, $remember)) {
            // Redirection selon le rôle de l'utilisateur après la connexion
            return match (Auth::user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'technicien' => redirect()->route('technicien.dashboard'),
                default => redirect()->route('login.form'),
            };
        }

        return back()->with('error', 'Identifiants incorrects.');
    }

    /**
     * Gère la déconnexion de l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Déconnexion de l'utilisateur

        $request->session()->invalidate(); // Invalider la session
        $request->session()->regenerateToken(); // Générer un nouveau token CSRF

        return redirect()->route('login.form')->with('success', 'Déconnexion réussie.');
    }
}
