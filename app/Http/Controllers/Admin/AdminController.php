<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Assurez-vous que cette ligne est présente
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Admin\Emetteur;

class AdminController extends Controller
{

    public function index()
    {
        $nombreEmetteurs = Emetteur::count();
        $notifs = Notification::where('user_id', 2)->get();
        // Assurez-vous que cette ligne fonctionne correctement
        return view('admin.dashboard', compact('nombreEmetteurs'), compact('notifs'));
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
