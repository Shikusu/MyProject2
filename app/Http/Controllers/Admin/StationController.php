<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Models\Admin\Station;  // Corrige l'importation pour correspondre à ton modèle

class StationController extends Controller
{
    // Exemple de méthode pour afficher les stations
    public function index()
    {
        $notifs = Notification::where('user_id', 2)->get();
        $stations = Station::all();  // Récupère toutes les stations depuis la base de données
        return view('admin.stations', compact('stations', 'notifs'));  // Retourne la vue avec les données
    }

    // Exemple d'une autre méthode
    public function show($id)
    {
        $station = Station::findOrFail($id);  // Trouve une station par ID
        return view('admin.station_show', compact('station'));  // Retourne la vue avec la station
    }
}
