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
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TechnicianController extends Controller
{
    public function dashboard()
    {
        $nombreEmetteurs = Emetteur::count();

        $maintenancesProches = Emetteur::with('localisation', 'derniereIntervention')
            ->whereNotNull('maintenance_prevue')
            ->orderBy('maintenance_prevue')
            ->paginate(2);

        $interventionsParJour = Intervention::selectRaw('DATE(date_reparation) as date, COUNT(*) as total')
            ->whereNotNull('date_reparation')
            ->where('date_reparation', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $notifs = Notification::where('user_id', 1)->get();

        $emetteursActifs = Emetteur::where('status', 'Actif')->count();
        $emetteursEnPanne = Emetteur::where('status', 'En panne')->count();
        $emetteursEnReparation = Emetteur::where('status', 'En cours de réparation')->count();

        return view('technicien.dashboard', compact(
            'nombreEmetteurs',
            'maintenancesProches',
            'interventionsParJour',
            'notifs',
            'emetteursActifs',
            'emetteursEnPanne',
            'emetteursEnReparation'
        ));
    }

    public function markAsRead($id)
    {
        $notif = Notification::find($id);
        if ($notif && !$notif->est_lu) {
            $notif->est_lu = 1;
            $notif->save();
        }

        return response()->json(['success' => true]);
    }

    public function emetteurs()
    {
        $emetteurs = Emetteur::with('localisation')->get();
        $aujourdhui = Carbon::today();

        foreach ($emetteurs as $emetteur) {
            if (is_null($emetteur->status)) {
                $emetteur->status = 'Actif';
                $emetteur->save();
            }

            $derniereIntervention = $emetteur->interventions()
                ->orderBy('date_reparation', 'desc')
                ->first();

            if ($derniereIntervention && $derniereIntervention->date_reparation) {
                $dateReparation = Carbon::parse($derniereIntervention->date_reparation);
                if ($aujourdhui->gte($dateReparation)) {
                    $emetteur->update([
                        'status' => 'Actif',
                        'derniere_maintenance' => now()
                    ]);
                }
            }
        }

        $notifs = Notification::where('user_id', 1)->get();

        return view('technicien.emetteurs', compact('emetteurs', 'notifs'));
    }

    public function historiques()
    {
        $notifs = Notification::where('user_id', 1)->get();

        $interventions = Intervention::with('emetteur')
            ->orderBy('date_panne', 'desc')
            ->whereNull('date_reparation')
            ->get();

        $pieces = Piece::all();

        return view('technicien.historiques', compact('interventions', 'pieces', 'notifs'));
    }

    public function deleteSelectedInterventions(Request $request)
    {
        $request->validate([
            'selected_interventions' => 'required|array',
            'selected_interventions.*' => 'exists:interventions,id',
        ]);

        Intervention::whereIn('id', $request->selected_interventions)->delete();

        return redirect()->route('technicien.historiques')
            ->with('success', 'Les interventions sélectionnées ont été supprimées avec succès.');
    }

    public function declencherPanne(Request $request, $emetteurId)
    {
        $validator = Validator::make($request->all(), [
            'date_panne' => 'required|date',
            'type' => 'required|string',
            'message' => 'nullable|string',
            'type_alerte' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emetteur = Emetteur::find($emetteurId);
        if (!$emetteur) {
            return redirect()->back()->with('error', 'Émetteur introuvable.');
        }

        $emetteur->update(['status' => 'En panne']);

        Alerte::create([
            'emetteur_id' => $emetteurId,
            'date_panne' => $request->input('date_panne'),
            'message' => $request->input('message'),
            'type_alerte' => $request->input('type_alerte'),
            'status' => 'non_lue',
        ]);

        Intervention::create([
            'emetteur_id' => $emetteurId,
            'date_panne' => $request->input('date_panne'),
            'type_alerte' => $request->input('type'),
        ]);

        return redirect()->route('technicien.alertes')->with('success', 'Alerte déclenchée.');
    }

    public function showRepairForm($id)
    {
        $intervention = Intervention::with('emetteur')->find($id);
        if (!$intervention) {
            return response()->json(['error' => 'Intervention non trouvée'], 404);
        }

        $pieces = Piece::all();

        return response()->json([
            'intervention' => $intervention,
            'emetteur' => $intervention->emetteur,
            'pieces' => $pieces,
        ]);
    }

    public function reparations($id)
    {
        $intervention = Intervention::with('emetteur')->findOrFail($id);
        $pieces = Piece::all();

        if ($intervention->emetteur) {
            $intervention->emetteur->update(['status' => 'En cours de réparation']);
        }

        return view('technicien.reparations', compact('intervention', 'pieces'));
    }

    public function saveRepair(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'date_reparation' => 'required|date',
        'pieces_utilisees' => 'nullable|array',
        'pieces_utilisees.*' => 'exists:pieces,id',
        'details_reparation' => 'required|string',
    ]);

    $validator->after(function ($validator) use ($request) {
        $date = Carbon::parse($request->input('date_reparation'));
        $now = Carbon::today();
        $max = $now->copy()->addDays(60);

        if ($date->lt($now)) {
            $validator->errors()->add('date_reparation', 'La date ne peut pas être dans le passé.');
        }
        if ($date->gt($max)) {
            $validator->errors()->add('date_reparation', 'La date ne peut pas dépasser 60 jours.');
        }
    });

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $intervention = Intervention::findOrFail($id);
    $emetteur = $intervention->emetteur;

    $dateReparation = Carbon::parse($request->input('date_reparation'));

    $intervention->update([
        'details_reparation' => $request->input('details_reparation'),
        'date_reparation' => $dateReparation,
    ]);

    if ($emetteur) {
        $emetteur->update([
            'status' => 'Actif',
            'derniere_maintenance' => $dateReparation,
            'maintenance_prevue' => $dateReparation->copy()->addDays(60),
        ]);
    }

    if ($request->has('pieces_utilisees')) {
        $pieces = Piece::whereIn('id', $request->input('pieces_utilisees'))->get();
        foreach ($pieces as $piece) {
            $piece->decrement('quantite', 1);
        }
        $intervention->pieces()->sync($request->input('pieces_utilisees'));
    }

    if ($intervention->alerte) {
        $intervention->alerte->update(['status' => 'Actif']);
    }

    return redirect()->route('technicien.historiques')->with('success', 'Réparation enregistrée avec succès.');
}


    public function lancerReparation(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date_reparation' => 'required|date|after_or_equal:today',
            'description' => 'nullable|string',
            'pieces' => 'nullable|array',
            'pieces.*.id' => 'required|exists:pieces,id',
            'pieces.*.quantite' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation échouée',
                'errors' => $validator->errors()
            ], 422);
        }

        $intervention = Intervention::findOrFail($id);
        $intervention->update([
            'date_reparation' => $request->date_reparation,
            'description' => $request->description,
        ]);

        $intervention->emetteur->update([
            'status' => 'En cours de réparation'
        ]);

        if ($request->has('pieces')) {
            foreach ($request->pieces as $pieceData) {
                $intervention->pieces()->attach($pieceData['id'], [
                    'quantite' => $pieceData['quantite']
                ]);
            }
        }

        return response()->json([
            'message' => 'Lancement de la réparation enregistré avec succès.'
        ]);
    }

    public function profil()
    {
        $notifs = Notification::where('user_id', 1)->get();
        $technicien = Auth::user();

        return view('technicien.profil', compact('technicien', 'notifs'));
    }

    public function updateDateEntree(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date_entree' => 'required|date',
        ]);

        $validator->after(function ($validator) use ($request, $id) {
            $dateEntree = Carbon::parse($request->input('date_entree'));
            $intervention = Intervention::where('emetteur_id', $id)
                ->orderBy('date_panne', 'desc')
                ->first();

            $aujourdhui = Carbon::today();

            if ($dateEntree->gt($aujourdhui)) {
                $validator->errors()->add('date_entree', 'La date d\'entrée ne peut pas être dans le futur.');
            }

            if ($intervention) {
                $datePanne = Carbon::parse($intervention->date_panne);
                $dateReparation = $intervention->date_reparation ? Carbon::parse($intervention->date_reparation) : null;

                if ($dateEntree->lte($datePanne)) {
                    $validator->errors()->add('date_entree', 'La date d\'entrée doit être après la date de panne.');
                }

                if ($dateReparation && $dateEntree->gte($dateReparation)) {
                    $validator->errors()->add('date_entree', 'La date d\'entrée doit être avant la date de réparation.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emetteur = Emetteur::findOrFail($id);
        $emetteur->date_entree = $request->input('date_entree');
        $emetteur->save();

        return redirect()->back()->with('success', 'Date d’entrée mise à jour avec succès.');
    }
}
