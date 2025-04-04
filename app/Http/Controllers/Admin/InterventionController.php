<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Alerte;
use App\Models\Admin\Piece;
use App\Models\Notification;
use App\Models\Admin\Intervention;
use App\Models\Admin\InterventionPiece;
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
        $request->validate([
            'date_reparation' => 'required|date',
            'date_reparation_fait' => 'required|date',
            'pieces' => 'nullable|array',
            'pieces.*.id' => 'exists:pieces,id',
            'pieces.*.quantite' => 'integer|min:1',
        ]);

        $intervention = Intervention::findOrFail($id);
        $emetteur = Emetteur::findOrFail($intervention->emetteur_id);

        if (!$emetteur) {
            return response()->json(['error' => 'Émetteur introuvable.'], 404);
        }

        if ($request->has('pieces')) {
            foreach ($request->pieces as $pieceData) {
                $piece = Piece::findOrFail($pieceData['id']);

                if ($piece->quantite < $pieceData['quantite']) {
                    return response()->json([
                        'error' => "Stock insuffisant pour la piece: {$piece->nom}.\n Disponible: {$piece->quantite}\n Demande: {$pieceData['quantite']}"
                    ], 400);
                }

                $piece->quantite -= $pieceData['quantite'];
                $piece->save();
                $Inter_piece = new InterventionPiece();
                $Inter_piece->intervention_id = $id;
                $Inter_piece->piece_id = $pieceData['id'];
                $Inter_piece->save();
            }
        }

        $intervention->date_reparation = $request->date_reparation;

        $emetteur->status = 'En cours de réparation';
        $emetteur->maintenance_prevue    = $request->date_reparation;

        $message = "La " . $emetteur->type . " localisée à " . $emetteur->localisation->nom . " est en cours de réparation";


        $notif = new Notification();
        $notif->message = $message;
        $notif->user_id = 2; //logik to be changet
        $notif->save();

        $intervention->date_reparation = $request->date_reparation;
        $intervention->date_reparation_fait = $request->date_reparation_fait;
        $intervention->save();

        return response()->json(['message' => 'Réparation enregistrée avec succès.']);
    }
}
