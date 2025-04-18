<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Localisation; // Ajouter le modèle Localisation
use Illuminate\Http\Request;
use App\Models\Notification;

class EmetteurController extends Controller
{
    // Affichage de la liste des émetteurs avec formulaire d'ajout et modification
    public function index()
    {
        // Récupère toutes les localisations
        $localisations = Localisation::all();
        $notifs = Notification::where('user_id', 2)->get();
        // Récupère les émetteurs avec leur localisation associée via une relation
        $emetteurs = Emetteur::with('localisation')->paginate(10);

        return view('admin.emetteurs', compact('localisations', 'emetteurs', 'notifs'));
    }

    // Affichage du formulaire d'ajout
    public function create()
    {
        // Récupère toutes les localisations
        $localisations = Localisation::all();

        return view('admin.emetteurs', compact('localisations'));
    }

    // Enregistrement d'un nouvel émetteur
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:radio,television',
            'localisation_id' => 'required|exists:localisations,id',
            'date_installation' => 'required|date',
            'maintenance_prevue' => 'nullable|date',
            'derniere_maintenance' => 'nullable|date',
        ]);

        Emetteur::create([
            'type' => $request->type,
            'localisation_id' => $request->localisation_id,
            'date_installation' => $request->date_installation,
            'maintenance_prevue' => $request->maintenance_prevue,
            'derniere_maintenance' => $request->derniere_maintenance,
        ]);

        return redirect()->back()->with('success', 'Émetteur ajouté avec succès');
    }



    // Affichage du formulaire d'édition
    public function edit($id)
    {

        $emetteurs = Emetteur::with('localisation')->paginate(10);
        // Récupérer l'émetteur avec la localisation associée
        $emetteur = Emetteur::with('localisation')->findOrFail($id);

        // Récupère toutes les localisations
        $localisations = Localisation::all();

        return view('admin.emetteurs', compact('emetteur', 'localisations', 'emetteurs'));
    }

    // Mise à jour d'un émetteur
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'localisation_id' => 'required',
            'date_installation' => 'required|date',
            'derniere_maintenance' => 'nullable|date',
            'maintenance_prevue' => 'nullable|date',
        ]);

        $emetteur = Emetteur::findOrFail($id);
        $emetteur->type = $request->type;
        $emetteur->localisation_id = $request->localisation_id;
        $emetteur->date_installation = $request->date_installation;
        $emetteur->derniere_maintenance = $request->derniere_maintenance;
        $emetteur->maintenance_prevue = $request->maintenance_prevue;
        $emetteur->save();

        return redirect()->route('admin.emetteurs.index')->with('success', 'Émetteur modifié avec succès.');
    }

    // Suppression d'un émetteur
    public function destroy($id)
    {
        $emetteur = Emetteur::findOrFail($id);
        $emetteur->delete();

        return redirect()->route('admin.emetteurs.index')->with('success', 'Émetteur supprimé avec succès.');
    }
}
