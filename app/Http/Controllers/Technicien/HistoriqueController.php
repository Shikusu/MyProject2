<?php

namespace App\Http\Controllers\Technicien;

use App\Http\Controllers\Controller;
use App\Models\Admin\Intervention;
use App\Models\Admin\Piece; // Ajout de l'importation du modèle Piece
use Illuminate\Http\Request;

class HistoriqueController extends Controller
{
    /**
     * Afficher l'historique des interventions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer toutes les interventions
        $interventions = Intervention::with('emetteur')
            ->orderBy('date_panne', 'desc')
            ->whereNull('date_reparation')
            ->get();

        // Récupérer toutes les pièces disponibles
        $pieces = Piece::all();

        // Passer les interventions et les pièces à la vue
        return view('technicien.historiques', compact('interventions', 'pieces'));
    }

    /**
     * Supprimer les interventions sélectionnées.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSelectedInterventions(Request $request)
    {
        // Valider les interventions sélectionnées
        $request->validate([
            'selected_interventions' => 'required|array',
            'selected_interventions.*' => 'exists:interventions,id', // Vérifier que chaque intervention existe
        ]);

        // Supprimer les interventions sélectionnées
        Intervention::whereIn('id', $request->selected_interventions)->delete();

        // Retourner vers la page des historiques avec un message de succès
        return redirect()->route('technicien.historiques')
            ->with('success', 'Les interventions sélectionnées ont été supprimées avec succès.');
    }
}
