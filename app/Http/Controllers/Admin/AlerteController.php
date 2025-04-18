<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Alerte;
use Illuminate\Http\Request;

class AlerteController extends Controller
{
    // Liste des types d'alerte
    public function index()
    {
<<<<<<< HEAD
        // Récupération des alertes avec pagination
        $alertes = Alerte::select('id', 'type')->paginate(5);  // Pagination des alertes


        // Envoi à la vue avec la pagination
        return view('admin.alertes', compact('alertes'));  // Envoi des alertes à la vue
=======
        $alertes = Alerte::paginate(5);

        // Récupération des notifications — ici, on suppose qu’elles sont liées à un user_id
        // Attention : vérifie bien que `Notification` utilise bien `user_id` (et pas `technicien_id`)
        $notifs = Notification::where('user_id', 2)->get();

        return view('admin.alertes', compact('alertes', 'notifs'));
>>>>>>> 0b3433a30e3fd718479fae58f69306470fb85508
    }

    // Ajouter un nouveau type d'alerte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
        ]);

<<<<<<< HEAD
        // Création de l'alerte
        $alerte = Alerte::create([
=======
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
>>>>>>> 0b3433a30e3fd718479fae58f69306470fb85508
            'type' => $validated['type'],
        ]);

<<<<<<< HEAD
        // Si la requête est en AJAX, retour de la réponse sous format JSON
=======
>>>>>>> 0b3433a30e3fd718479fae58f69306470fb85508
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'alerte' => $alerte,
            ]);
        }

        // Redirection avec message de succès
        return redirect()->route('admin.alertes.index')->with('success', 'Type d\'alerte ajouté avec succès!');
    }

    // Modifier un type d'alerte
    public function edit($id)
    {
        // Trouver l'alerte par ID
        $alerte = Alerte::findOrFail($id);

        // Retourner l'alerte sous format JSON
        return response()->json([
            'success' => true,
            'alerte' => $alerte,
        ]);
    }

    // Mettre à jour un type d'alerte
    public function update(Request $request, $id)
    {
        // Validation de la demande
        $validated = $request->validate([
            'type' => 'required|string|max:69',
        ]);

        // Trouver l'alerte par ID
        $alerte = Alerte::findOrFail($id);
        $alerte->update([
            'type' => $validated['type'],
        ]);

        // Retourner la réponse sous format JSON
        return response()->json([
            'success' => true,
            'alerte' => $alerte,
        ]);
    }

    // Supprimer un type d'alerte
    public function destroy($id)
    {
        // Trouver l'alerte par ID et la supprimer
        $alerte = Alerte::findOrFail($id);
        $alerte->delete();

        // Retourner une réponse JSON de succès
        return response()->json(['success' => true]);
    }
}
