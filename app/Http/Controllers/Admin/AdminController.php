<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Assurez-vous que cette ligne est présente
use Illuminate\Http\Request;
use App\Models\Admin\Emetteur;
// Ajout du débogage pour vérifier si la classe Controller existe
// dd(class_exists(\App\Http\Controllers\Controller::class));

class AdminController extends Controller
{

    public function index()
{
    $nombreEmetteurs = Emetteur::count();  // Assurez-vous que cette ligne fonctionne correctement
    return view('admin.dashboard', compact('nombreEmetteurs'));
}
    public function manageUsers()
    {
        return view('admin.manage_users');
    }

    public function manageEquipments()
    {
        return view('admin.manage_equipments');
    }

    public function viewReports()
    {
        return view('admin.view_reports');
    }

}
