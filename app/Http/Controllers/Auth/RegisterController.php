<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        // Vérifie si un admin existe déjà
        $adminExists = User::where('role', 'admin')->exists();
        return view('auth.register', compact('adminExists'));
    }

    /**
     * Handle the registration request.
     */
    public function register(Request $request)
    {
        // Valider les données du formulaire
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:technicien' . (User::where('role', 'admin')->exists() ? '' : ',admin'),
        ]);

        // Vérifier les erreurs de validation
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Créer un nouvel utilisateur
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Hash du mot de passe
        $user->role = $request->role;
        $user->save(); // Sauvegarde dans la base de données

        return redirect()->route('login.form')->with('success', 'Inscription réussie !');
    }
}
