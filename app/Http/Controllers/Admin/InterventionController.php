<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Alerte;
use App\Models\Admin\Piece;
use App\Models\Notification;
use App\Models\Admin\Intervention;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    // Afficher la liste des interventions
    public function index()
    {
        $emetteurs = Emetteur::with('localisation', 'interventions')->get();
        $alertesTypes = Alerte::distinct()->pluck('type', 'type');
        $interventions = Intervention::whereNotNull('date_reparation')->get();

        return view('admin.interventions', compact('emetteurs', 'alertesTypes', 'interventions'));
    }


    // Déclencher une alerte pour une panne
    public function declencherPanne(Request $request, $emetteurId)
    {
        // Validation des données envoyées
        $request->validate([
            'date_panne' => 'required|date|before_or_equal:today',
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
        $emetteur->status = 'panne';
        $emetteur->date_panne = $request->date_panne;
        $emetteur->save();

        //creation notif
        $message = "La " . $emetteur->type . " localisée à " . $emetteur->localisation->nom . " est en panne";


        $notif = new Notification();
        $notif->message = $message;
        $notif->user_id = 1; //logik to be changet
        $notif->save();

        // Redirection avec un message de succès
        return redirect()->route('admin.interventions.index')->with('success', 'Panne déclenchée avec succès.');
    }

    public function lancementReparation(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'date_reparation' => 'required|date',
            'date_reparation_fait' => 'required|date',
        ]);

        // Find the intervention by ID
        $intervention = Intervention::findOrFail($id);
        $emetteur = Emetteur::findOrFail($intervention->emetteur_id);
        if (!$emetteur) {
            return response()->json(['error' => 'Intervention not found'], 404);
        }
        // Update fields
        $intervention->date_reparation = $request->date_reparation;

        $emetteur->status = 'En cours de réparation';

        $message = "La " . $emetteur->type . " localisée à " . $emetteur->localisation->nom . " est en cours de réparation";


        $notif = new Notification();
        $notif->message = $message;
        $notif->user_id = 2; //logik to be changet
        $notif->save();

        $intervention->date_reparation_fait = $request->date_reparation_fait;
        $intervention->save();
        $emetteur->save();

        if ($request->has('pieces')) {
            $pieceIds = [];
            foreach ($request->pieces as $pieceName) {
                $piece = Piece::firstOrCreate(['nom' => $pieceName]);
                $pieceIds[] = $piece->id;
            }

            $intervention->pieces()->sync($pieceIds);
        }
        return response()->json(['success' => true, 'message' => 'Réparation et pièces enregistrées avec succès.']);
    }
}
