<?php

namespace App\Http\Controllers\Technicien;

use App\Models\Admin\Emetteur;

use App\Models\Admin\Intervention;
use App\Models\Admin\Alerte;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TechnicianEmetteurController extends Controller
{
    /**
     * Afficher la liste des émetteurs pour le technicien.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupérer tous les émetteurs avec leur localisation associée
        $emetteurs = Emetteur::with('localisation')->get();
        // Compter les alertes non lues pour le technicien
        $user = Auth::user();
        $notificationsCount = Alerte::where('technicien_id', $user->id)
            ->where('status', 'non_lue')
            ->count(); // Compter les alertes non lues

        $interventions = Intervention::with('emetteur')
            ->get();

        // Retourner la vue avec les émetteurs et le compteur d'alertes non lues
        return view('technicien.emetteurs', compact('emetteurs', 'notificationsCount', 'interventions'));
    }

    /**
     * Afficher les alertes pour un technicien.
     *
     * @return \Illuminate\View\View
     */
    public function showAlertes()
    {
        // Vérifier si l'utilisateur est authentifié
        $user = Auth::user();

        if (!$user) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
            return redirect()->route('login.form')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer les alertes non lues pour le technicien
        $alertes = Alerte::where('technicien_id', $user->id)
            ->where('status', 'non_lue')
            ->get();

        // Retourner la vue avec les alertes
        return view('technicien.alertes', compact('alertes'));
    }

    /**
     * Marquer une alerte comme lue.
     *
     * @param int $alerteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function marquerCommeLue($alerteId)
    {
        // Vérifier si l'utilisateur est authentifié
        $user = Auth::user();

        if (!$user) {
            // Rediriger si l'utilisateur n'est pas authentifié
            return redirect()->route('login.form')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Trouver l'alerte par son ID
        $alerte = Alerte::findOrFail($alerteId);

        // Vérifier si l'alerte appartient à l'utilisateur technicien
        if ($alerte->technicien_id === $user->id) {
            // Mettre à jour le statut de l'alerte
            $alerte->status = 'lue';
            $alerte->save();

            return back()->with('success', 'Alerte marquée comme lue.');
        }

        // Si l'alerte ne correspond pas au technicien, retourner une erreur
        return back()->with('error', 'Accès non autorisé à cette alerte.');
    }

    /**
     * Afficher les détails d'un émetteur pour intervention.
     *
     * @param int $emetteurId
     * @return \Illuminate\View\View
     */
    public function showEmetteurDetails($emetteurId)
    {
        // Trouver l'émetteur par son ID
        $emetteur = Emetteur::with('localisation')->findOrFail($emetteurId);

        // Retourner la vue avec les détails de l'émetteur
        return view('technicien.emetteur_details', compact('emetteur'));
    }
}
