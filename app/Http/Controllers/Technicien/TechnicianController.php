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
        $notifs = Notification::where('user_id', Auth::id())->get();

        return view('technicien.dashboard', compact('nombreEmetteurs', 'notifs'));
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
        $emetteurs = Emetteur::with('localisation')->get();

        foreach ($emetteurs as $emetteur) {
            if (is_null($emetteur->status)) {
                $emetteur->status = 'Actif';
                $emetteur->save();
            }
        }

        $notifs = Notification::where('user_id', Auth::id())->get();

        return view('technicien.emetteurs', compact('emetteurs', 'notifs'));
    }

    public function historiques()
    {
        $interventions = Intervention::with(['emetteur', 'alerte'])
            ->orderBy('date_panne', 'desc')
            ->get();

        foreach ($interventions as $intervention) {
            $intervention->is_new = Carbon::parse($intervention->date_panne)->gt(now()->subDays(7));
        }

        $pieces = Piece::all();

        return view('technicien.historiques', compact('interventions', 'pieces'));
    }


    public function declencherPanne(Request $request, $emetteurId)
    {
        $validator = Validator::make($request->all(), [
            'date_panne' => 'required|date',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $emetteur = Emetteur::find($emetteurId);
        if (!$emetteur) {
            return redirect()->back()->with('error', 'Émetteur introuvable.');
        }

        $emetteur->update(['status' => 'En panne']);

        // Créer une alerte avec uniquement "id" et "type"
        $alerte = Alerte::create([
            'type' => $request->input('type'),
        ]);

        // Lier l'alerte à l'intervention uniquement via type
        Intervention::create([
            'emetteur_id' => $emetteurId,
            'date_panne' => $request->input('date_panne'),
            'type_alerte' => $request->input('type'),
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
            'pieces_utilisees' => 'nullable|array',
            'pieces_utilisees.*' => 'exists:pieces,id',
            'details_reparation' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $intervention = Intervention::findOrFail($id);
        $emetteur = $intervention->emetteur;

        $intervention->update([
            'status' => 'Résolu',
            'details_reparation' => $request->input('details_reparation'),
            'date_reparation' => now(),
        ]);

        if ($emetteur) {
            $emetteur->update([
                'status' => 'Actif',
                'derniere_maintenance' => now(),
            ]);
        }

        if ($request->has('pieces_utilisees')) {
            $pieces = Piece::whereIn('id', $request->input('pieces_utilisees'))->get();
            foreach ($pieces as $piece) {
                $piece->decrement('quantite', 1);
            }
            $intervention->pieces()->sync($request->input('pieces_utilisees'));
        }

        // Si tu veux marquer l'alerte comme traitée manuellement
        if ($intervention->alerte) {
            $intervention->alerte->update(['status' => 'traitée']);
        }

        return redirect()->route('technicien.historiques')->with('success', 'Réparation enregistrée avec succès.');
    }

    public function profil()
    {
        $technicien = Auth::user();
        return view('technicien.profil', compact('technicien'));
    }
}
