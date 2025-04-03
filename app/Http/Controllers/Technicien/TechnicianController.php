<?php

namespace App\Http\Controllers\Technicien;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Alerte;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Intervention;
use App\Models\Notification;
use App\Models\Admin\Piece;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TechnicianController extends Controller
{
    public function dashboard()
    {
        $nombreEmetteurs = Emetteur::count();
        $notifs = Notification::where('user_id', 1)->get();

        return view('technicien.dashboard', compact('nombreEmetteurs'), compact('notifs'));
    }


    public function markAsRead($id)
    {
        $notif = Notification::find($id);
        if ($notif && $notif->est_lu == 0) {
            $notif->est_lu = 1;
            $notif->save();
        }

        return response()->json(['success' => true]);
    }

    public function emetteurs()
    {
        // Récupère tous les émetteurs avec leur localisation
        $emetteurs = Emetteur::with('localisation')->get();

        // Si le statut est null, on lui assigne une valeur par défaut
        foreach ($emetteurs as $emetteur) {
            if (is_null($emetteur->status)) {
                $emetteur->status = 'Actif';  // Valeur par défaut si statut est vide
                $emetteur->save();  // Sauvegarder le statut dans la base de données
            }
        }

        return view('technicien.emetteurs', compact('emetteurs'));
    }

    public function historiques()
    {
        $interventions = Intervention::with(['emetteur', 'alerte'])
            ->orderBy('date_panne', 'desc')
            ->get();

        foreach ($interventions as $intervention) {
            $intervention->is_new = Carbon::parse($intervention->date_panne)->gt(now()->subDays(7));
        }

        $pieces = Piece::all(); // Charger les pièces disponibles

        return view('technicien.historiques', compact('interventions', 'pieces'));
    }

    public function supprimerInterventionsSelectionnees(Request $request)
    {
        $selectedInterventions = $request->input('selected_interventions');

        if (empty($selectedInterventions)) {
            return back()->with('error', 'Aucune intervention sélectionnée');
        }

        Intervention::whereIn('id', $selectedInterventions)->delete();

        return back()->with('success', 'Interventions supprimées avec succès');
    }

    public function declencherPanne(Request $request, $emetteurId)
    {
        $validator = Validator::make($request->all(), [
            'date_panne' => 'required|date',
            'message' => 'required|string',
            'type_alerte' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emetteur = Emetteur::find($emetteurId);
        if (!$emetteur) {
            return redirect()->back()->with('error', 'Émetteur introuvable.');
        }

        // Mettre à jour l'état de l'émetteur en "En panne"
        $emetteur->update(['status' => 'En panne']);

        // Créer une alerte
        $alerte = Alerte::create([
            'emetteur_id' => $emetteurId,
            'date_panne' => $request->input('date_panne'),
            'message' => $request->input('message'),
            'type_alerte' => $request->input('type_alerte'),
            'status' => 'non_lue',
        ]);

        // Créer une intervention associée à l'alerte
        Intervention::create([
            'emetteur_id' => $emetteurId,
            'date_panne' => $request->input('date_panne'),
            'message' => $request->input('message'),
            'type_alerte' => $request->input('type_alerte'),
            'status' => 'En cours de réparation',
        ]);

        return redirect()->route('technicien.alertes')->with('success', 'Alerte déclenchée.');
    }

    public function showRepairForm($id)
    {
        $intervention = Intervention::with('emetteur')->find($id);

        if (!$intervention) {
            return response()->json(['error' => 'Intervention non trouvée'], 404);
        }

        $pieces = Piece::all(); // Récupérer toutes les pièces disponibles

        return response()->json([
            'intervention' => $intervention,
            'emetteur' => $intervention->emetteur,
            'pieces' => $pieces,
        ]);
    }

    public function reparations($id)
    {
        $intervention = Intervention::with('emetteur')->findOrFail($id);
        $pieces = Piece::all(); // Charger toutes les pièces disponibles

        // Mettre à jour l'état de l'émetteur en "En cours de réparation"
        if ($intervention->emetteur) {
            $intervention->emetteur->update(['status' => 'En cours de réparation']);
        }

        return view('technicien.reparations', compact('intervention', 'pieces'));
    }

    public function saveRepair(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pieces_utilisees' => 'nullable|array',
            'pieces_utilisees.*' => 'exists:pieces,id',
            'details_reparation' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $intervention = Intervention::findOrFail($id);
        $emetteur = $intervention->emetteur;

        // Mettre à jour l'intervention
        $intervention->update([
            'status' => 'Résolu',
            'details_reparation' => $request->input('details_reparation'),
            'date_reparation' => now(),
        ]);

        // Mettre à jour l'état de l'émetteur en "Actif"
        if ($emetteur) {
            $emetteur->update([
                'status' => 'Actif',
                'derniere_maintenance' => now(),
            ]);
        }

        // Associer les pièces utilisées à l'intervention et mettre à jour le stock
        if ($request->has('pieces_utilisees')) {
            $pieces = Piece::whereIn('id', $request->input('pieces_utilisees'))->get();
            foreach ($pieces as $piece) {
                $piece->decrement('quantite', 1);
            }
            $intervention->pieces()->sync($request->input('pieces_utilisees'));
        }

        // Marquer l'alerte associée comme traitée
        if ($intervention->alerte) {
            $intervention->alerte->update(['status' => 'traitée']);
        }

        return redirect()->route('technicien.historiques')->with('success', 'Réparation enregistrée avec succès.');
    }
}
