<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Localisation;
use App\Models\Admin\Piece;
use App\Models\Admin\Alerte;
use App\Models\Admin\Intervention;
use App\Models\User;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        // Comptage des émetteurs selon leur statut
        $nombreEmetteursActifs = Emetteur::where('status', 'Actif')->count();
        $nombreEmetteursPanne = Emetteur::where('status', 'En panne')->count();
        $nombreEmetteursEnReparation = Emetteur::where('status', 'En cours de réparation')->count();

        // Autres comptages
        $nombreLocalisations = Localisation::count();
        $nombrePieces = Piece::count();
        $nombreAlertes = Alerte::count();
        $nombreInterventions = Intervention::count();

        $notifs = Notification::where('user_id', 2)->get();

           // Liste des émetteurs avec localisation chargée (eager loading)
        $emetteurs = Emetteur::with('localisation')->get();
            $emetteurs = Emetteur::with('localisation')->paginate(5);

        // Liste paginée des émetteurs
        $emetteurs = Emetteur::with('localisation')->orderBy('created_at', 'desc')->paginate(5);

        // Récupérer les techniciens
        $techniciens = User::where('role', 'technicien')->get();
        $nombreEmetteursTotal = $nombreEmetteursActifs + $nombreEmetteursPanne + $nombreEmetteursEnReparation;

        // Passer toutes les variables à la vue
        return view('admin.dashboard', compact(
            'nombreEmetteursActifs',
            'nombreEmetteursPanne',
            'nombreEmetteursEnReparation',
            'techniciens',
            'nombreLocalisations',
            'nombrePieces',
            'nombreAlertes',
            'nombreInterventions',
            'emetteurs',
            'notifs',
        ));
    }
}
