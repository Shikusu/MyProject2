<?php

namespace App\Http\Controllers\Technicien;

use App\Models\Admin\Emetteur;
use App\Models\Admin\Intervention;
use App\Models\Admin\Alerte;
use Illuminate\Http\Request;
use App\Models\Notification;
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
                $notifs = Notification::where('user_id', 1)->get();


        // Compter les alertes non lues pour le technicien
        $user = Auth::user();
        $interventions = Intervention::with('emetteur')
            ->get();
        $notifs = Intervention::with('emetteur')
            ->get();


        $notificationsCount = Alerte::count(); // Compte simplement toutes les alertes

        $interventions = Intervention::with('emetteur')->get();
        $notifs = Intervention::with('emetteur')->get();

        return view('technicien.emetteurs', compact('emetteurs', 'notificationsCount', 'interventions', 'notifs'));
    }

    /**
     * Afficher les alertes pour un technicien.
     *
     * @return \Illuminate\View\View
     */
    // public function showAlertes()
    // {
    //     // Afficher toutes les alertes sans filtrage sur 'technicien_id' ou 'is_read'
    //     $alertes = Alerte::all();

    //     if (!$user) {
    //         // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
    //         return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
    //     }


    //     // Retourner la vue avec les alertes
    // return view('technicien.alertes', compact('alertes'));
    // }

    /**
     * Marquer une alerte comme lue.
     *
     * @param int $alerteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function marquerCommeLue($alerteId)
    {

        // Il n'y a plus de champ "status", donc on ne fait rien ici
        return back()->with('info', 'Aucune action effectuée car le champ "status" n’existe plus.');
        // Vérifier si l'utilisateur est authentifié
        $user = Auth::user();

        if (!$user) {
            // Rediriger si l'utilisateur n'est pas authentifié
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
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
        $notifs = Notification::where('user_id', 1)->get();
        // Retourner la vue avec les détails de l'émetteur
        return view('technicien.emetteur_details', compact('emetteur', 'notifs'));
    }
}
