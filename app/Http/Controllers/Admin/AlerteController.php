<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Alerte;
use Illuminate\Http\Request;
use App\Models\Notification;


class AlerteController extends Controller
{
    // Afficher la liste des alertes
    public function index(Request $request)
    {

        $notifs = Notification::where('user_id', 2)->get();
        // Récupérer les alertes paginées
        $alertes = Alerte::paginate(5);

        // Renvoyer la vue avec la liste des alertes
        return view('admin.alertes', compact('alertes', 'notifs'));
    }

    // Ajouter une alerte
    public function store(Request $request)
    {
        // Validation avec vérification que le type d'alerte n'existe pas déjà
        $validated = $request->validate([
            'typeA' => 'required|string|max:50|unique:type_alerte,typeA',
        ]);

        // Création de l'alerte
        $alerte = Alerte::create([
            'typeA' => $validated['typeA'],
        ]);

        // Réponse AJAX après la création de l'alerte
        return redirect()->route('admin.alertes.index')->with('success', 'Alerte ajouté avec succès!');
    }

    // Modifier une alerte
    public function update(Request $request, $id)
    {
        try {
            // Validation avec vérification que le type d'alerte est unique
            $validated = $request->validate([
                'typeA' => 'required|string|max:69|unique:type_alerte,typeA,' . $id,
            ]);

            // Trouver l'alerte par son ID
            $alerte = Alerte::findOrFail($id);
            $alerte->update([
                'typeA' => $validated['typeA'],
            ]);

            // Réponse AJAX après la mise à jour de l'alerte
            return response()->json([
                'success' => true,
                'alerte' => $alerte,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Si une erreur de validation se produit
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Si une autre erreur se produit
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur',
            ], 500);
        }
    }

    // Supprimer une alerte
    public function destroy($id)
    {
        try {
            // Trouver l'alerte par son ID
            $alerte = Alerte::findOrFail($id);
            $alerte->delete();

            // Réponse AJAX après la suppression de l'alerte
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Si une erreur se produit lors de la suppression
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
            ], 500);
        }
    }
}
