<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Alerte;
use App\Models\User;
use App\Models\Admin\Emetteur;
use App\Models\Notification;
use Illuminate\Http\Request;

class AlerteController extends Controller
{
    // Afficher les alertes avec pagination de 5 par page
    public function index()
    {
        $alertes = Alerte::paginate(5);

        // Récupération des notifications — ici, on suppose qu’elles sont liées à un user_id
        // Attention : vérifie bien que `Notification` utilise bien `user_id` (et pas `technicien_id`)
        $notifs = Notification::where('user_id', 2)->get();

        return view('admin.alertes', compact('alertes', 'notifs'));
    }

    // Ajouter une nouvelle alerte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'message' => 'required|string|max:255',
            'emetteur_id' => 'required|exists:emetteurs,id',
        ]);

        $emetteur = Emetteur::findOrFail($validated['emetteur_id']);

        // On récupère le technicien, mais ce champ sera utilisé uniquement dans la table `alertes`
        $technicien = User::where('role', 'technicien')->first();

        if (!$technicien) {
            return redirect()->back()->with('error', 'Aucun technicien disponible.');
        }

        // Création de l’alerte
        $alerte = Alerte::create([
            'emetteur_id' => $emetteur->id,
            'technicien_id' => $technicien->id, // Ne touche pas la table `type_alerte`, donc OK
            'date_alerte' => now(),
            'message' => $validated['message'],
            'type' => $validated['type'],
            'resolue' => false,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'alerte' => $alerte
            ]);
        }

        return redirect()->route('admin.alertes.index')->with('success', 'Alerte ajoutée avec succès!');
    }

    // Modifier une alerte
    public function edit($id)
    {
        $alerte = Alerte::findOrFail($id);
        return response()->json([
            'success' => true,
            'alerte' => $alerte
        ]);
    }

    // Mettre à jour une alerte
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'message' => 'required|string|max:255',
        ]);

        $alerte = Alerte::findOrFail($id);
        $alerte->update([
            'type' => $validated['type'],
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'alerte' => $alerte
        ]);
    }

    // Supprimer une alerte
    public function destroy($id)
    {
        $alerte = Alerte::findOrFail($id);
        $alerte->delete();

        return response()->json(['success' => true]);
    }

    // Résoudre une alerte
    public function resolve($id)
    {
        $alerte = Alerte::findOrFail($id);
        $alerte->update(['resolue' => true]);

        return redirect()->route('admin.alertes.index')->with('success', 'Alerte résolue avec succès!');
    }

    // Marquer une alerte comme en cours
    public function inProgress($id)
    {
        $alerte = Alerte::findOrFail($id);
        $alerte->update(['resolue' => false]);

        return redirect()->route('admin.alertes.index')->with('success', 'Alerte en cours de traitement!');
    }
}
