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
     * Affiche le formulaire d'inscription.
     */
    public function showRegistrationForm()
    {
        // Vérifie si un admin existe déjà
        $adminExists = User::where('role', 'admin')->exists();
        return view('auth.register', compact('adminExists'));
    }

    /**
     * Gère l'enregistrement d'un nouvel utilisateur.
     */
    public function register(Request $request)
    {
        // Définir les règles de validation
        $rules = [
            'name' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'matricule' => 'required|string|max:50|unique:users,matricule',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:technicien', // Par défaut que technicien
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ];

        // Autoriser le rôle admin si aucun admin n'existe
        if (!User::where('role', 'admin')->exists()) {
            $rules['role'] = 'required|in:technicien,admin';
        }

        // Valider les données
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Gérer l'upload de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Créer l'utilisateur
        $user = new User();
        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->matricule = $request->matricule;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->photo = $photoPath; // chemin relatif ou null
        $user->save();

        return redirect()->route('login')->with('success', 'Inscription réussie ! Vous pouvez vous connecter.');
    }
}
