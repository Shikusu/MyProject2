<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Alerte;
use App\Models\Admin\Intervention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InterventionController extends Controller
{
    // Afficher la liste des interventions
    public function index()
    {
        $emetteurs = Emetteur::with('localisation', 'interventions')->get();
        $alertesTypes = Alerte::distinct()->pluck('type', 'type');
        $interventions = Intervention::with('emetteur')->get();

        return view('admin.interventions', compact('emetteurs', 'alertesTypes', 'interventions'));
    }

    // Déclencher une alerte pour une panne
    public function declencherPanne(Request $request, $emetteurId)
    {
        // Validation des données envoyées
        $request->validate([
            'date_panne' => 'required|date',
            'message' => 'required|string',
            'type_alerte' => 'required|string',
        ]);

        // Trouver l'émetteur
        $emetteur = Emetteur::findOrFail($emetteurId);

        // Créer une nouvelle intervention
        $intervention = new Intervention();
        $intervention->emetteur_id = $emetteur->id;
        $intervention->date_panne = $request->date_panne;
        $intervention->message = $request->message;
        $intervention->type_alerte = $request->type_alerte;
        $intervention->save();


        //maj emetteur
        $emetteur->panne_declenchee = 1;
        $emetteur->date_panne = $request->date_panne;
        $emetteur->save();


        // Redirection avec un message de succès
        return redirect()->route('admin.interventions.index')->with('success', 'Panne déclenchée avec succès.');
    }
}
