<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Affiche la vue du profil
    public function show()
    {
        $admin = Auth::user(); // Récupère l'utilisateur connecté
        return view('admin.profile', compact('admin'));
    }

    // Mise à jour des informations personnelles (nom, prénom, email, photo)
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validation
        $request->validate([
            'name' => 'required|string|max:25',
            'prenom' => 'required|string|max:30',
            'email' => [
                'required',
                'email',
                'max:25',
                Rule::unique('users')->ignore($user->id),
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Mise à jour des champs texte
        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->email = $request->email;

        // Upload photo
        if ($request->hasFile('photo')) {
            // Supprimer ancienne photo si existante
            if ($user->photo && Storage::exists('public/photos/' . $user->photo)) {
                Storage::delete('public/photos/' . $user->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/photos', $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }

    // Mise à jour du mot de passe
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
