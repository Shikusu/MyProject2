<?php

namespace App\Http\Controllers\Technicien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class ProfileController extends Controller
{
     // Mise à jour des informations du profil
    public function updateProfile(Request $request)
    {

        $technicien = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'prenom' => ['nullable', 'string', 'max:30'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($technicien->id),'max(30)'
            ],
            'photo' => ['nullable', 'image', 'max:2048'], // max 2Mo
        ]);

        $technicien->name = $request->input('name');
        $technicien->prenom = $request->input('prenom');
        $technicien->email = $request->input('email');

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si existante
            if ($technicien->photo) {
                Storage::disk('public')->delete($technicien->photo);
            }
            $path = $request->file('photo')->store('techniciens/photos', 'public');
            $technicien->photo = $path;
        }

        $technicien->save();

        return redirect()->route('technicien.profil')->with('success', 'Profil mis à jour avec succès.');
    }

    // Mise à jour du mot de passe
    public function update(Request $request)
    {
    $technicien = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // password_confirmation doit être présent dans le form
        ]);

        if (!Hash::check($request->input('current_password'), $technicien->password)) {
            return redirect()->route('technicien.profil')
                ->with('password_error', 'Le mot de passe actuel est incorrect.');
        }

        $technicien->password = Hash::make($request->input('password'));
        $technicien->save();

        return redirect()->route('technicien.profil')->with('success', 'Mot de passe modifié avec succès.');
    }
}
