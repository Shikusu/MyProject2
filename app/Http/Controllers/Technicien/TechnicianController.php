<?php

namespace App\Http\Controllers\Technicien;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Alerte;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Intervention;
use App\Models\Admin\Piece;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TechnicianController extends Controller
{
    public function dashboard()
    {
        $nombreEmetteurs = Emetteur::count();
        return view('technicien.dashboard', compact('nombreEmetteurs'));
    }

    public function emetteurs()
    {
        $emetteurs = Emetteur::with('localisation')->get();
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
            'status' => 'en_cours',
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
        $intervention->update([
            'status' => 'resolu',
            'details_reparation' => $request->input('details_reparation'),
        ]);

        // Associer les pièces utilisées à l'intervention
        if ($request->has('pieces_utilisees')) {
            $intervention->pieces()->sync($request->input('pieces_utilisees'));
        }

        return redirect()->route('technicien.historiques')->with('success', 'Réparation enregistrée.');
    }
}
