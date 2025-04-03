<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Localisation; // Ajouter le modèle Localisation
use Illuminate\Http\Request;

class EmetteurController extends Controller
{
    // Affichage de la liste des émetteurs avec formulaire d'ajout et modification
    public function index()
    {
        // Récupère toutes les localisations
        $localisations = Localisation::all();

        // Récupère les émetteurs avec leur localisation associée via une relation
        $emetteurs = Emetteur::with('localisation')->paginate(10);

        return view('admin.emetteurs', compact('localisations', 'emetteurs'));
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
            'type' => 'required',
            'id_localisation' => 'required',
            'date_installation' => 'required|date',
            'dernier_maintenance' => 'nullable|date',
            'maintenance_prevue' => 'nullable|date',
        ]);

        $emetteur = new Emetteur();
        $emetteur->type = $request->type;
        $emetteur->id_localisation = $request->id_localisation;
        $emetteur->date_installation = $request->date_installation;
        $emetteur->dernier_maintenance = $request->dernier_maintenance;
        $emetteur->maintenance_prevue = $request->maintenance_prevue;
        $emetteur->save();

        return redirect()->route('admin.emetteurs.index')->with('success', 'Émetteur ajouté avec succès.');
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
            'id_localisation' => 'required',
            'date_installation' => 'required|date',
            'dernier_maintenance' => 'nullable|date',
            'maintenance_prevue' => 'nullable|date',
        ]);

        $emetteur = Emetteur::findOrFail($id);
        $emetteur->type = $request->type;
        $emetteur->id_localisation = $request->id_localisation;
        $emetteur->date_installation = $request->date_installation;
        $emetteur->dernier_maintenance = $request->dernier_maintenance;
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
