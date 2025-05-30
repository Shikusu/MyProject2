<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Localisation;
use App\Models\Admin\Piece;
use App\Models\Admin\Alerte;
use App\Models\Admin\Intervention;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index()
    {
        $techniciens = User::where('role', 'technicien')->get();


        $nombreEmetteursActifs = Emetteur::where('status', 'Actif')->count();
        $nombreEmetteursPanne = Emetteur::where('status', 'En panne')->count();
        $nombreEmetteursEnReparation = Emetteur::where('status', 'En cours de réparation')->count();

        $nombreLocalisations = Localisation::count();
        $nombrePieces = Piece::count();
        $nombreAlertes = Alerte::count();
        $nombreInterventions = Intervention::count();

        $notifs = Notification::where('user_id', 2)->get();

         // Liste des émetteurs avec localisation chargée (eager loading)
        $emetteurs = Emetteur::with('localisation')->get();
            $emetteurs = Emetteur::with('localisation')->paginate(5);


        return view('admin.dashboard', compact(
            'techniciens',
            'nombreEmetteursActifs',
            'nombreEmetteursPanne',
            'nombreEmetteursEnReparation',
            'nombreLocalisations',
            'nombrePieces',
            'nombreAlertes',
            'nombreInterventions',
            'emetteurs',
            'notifs'
        ));
    }
}
