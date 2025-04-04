<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Localisation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocalisationController extends Controller
{
    // Affiche la liste des localisations
    public function index()
    {
        $localisations = Localisation::paginate(10); // Affiche 10 localisations par page
        return view('admin.localisations', compact('localisations'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('admin.localisations');
    }

    // Enregistre une nouvelle localisation
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        Localisation::create([
            'nom' => $request->input('nom'),
        ]);

        return redirect()->route('admin.localisations.index')->with('success', 'Localisation ajoutée avec succès');
    }

    // Affiche le formulaire d'édition pour une localisation existante
    public function edit($id)
    {

        $localisations = Localisation::paginate(10);
        $localisation = Localisation::findOrFail($id);
        return view('admin.localisations', compact('localisation', 'localisations'));
    }

    // Met à jour une localisation existante
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $localisation = Localisation::findOrFail($id);
        $localisation->nom = $request->input('nom');
        $localisation->save();

        return redirect()->route('admin.localisations.index')->with('success', 'Localisation mise à jour avec succès');
    }

    // Supprime une localisation
    public function destroy($id)
    {
        $localisation = Localisation::findOrFail($id);
        $localisation->delete();

        return redirect()->route('admin.localisations.index')->with('success', 'Localisation supprimée avec succès');
    }
}
