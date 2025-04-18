<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Intervention;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Comptage des émetteurs selon leur statut

        // Récupérer les 3 dernières notifications

        $nombreEmetteursActifs = Emetteur::where('status', 'active')->count();
        $nombreEmetteursPanne = Emetteur::where('status', 'panne')->count();
        $nombreEmetteursEnReparation = Emetteur::where('status', 'reparation')->count();

        // Passer les variables à la vue
        return view('admin.dashboard', compact('nombreEmetteursActifs', 'nombreEmetteursPanne', 'nombreEmetteursEnReparation', 'notifs'));
    }
}
