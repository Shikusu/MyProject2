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
        // Récupération des alertes avec pagination
        $alertes = Alerte::select('id', 'type')->paginate(5);  // Pagination des alertes


        // Envoi à la vue avec la pagination
        return view('admin.alertes', compact('alertes'));  // Envoi des alertes à la vue
    }

    // Ajouter un nouveau type d'alerte
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
        ]);

        // Création de l'alerte
        $alerte = Alerte::create([
            'type' => $validated['type'],
        ]);

        // Si la requête est en AJAX, retour de la réponse sous format JSON
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
