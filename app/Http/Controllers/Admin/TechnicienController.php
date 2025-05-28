<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Models\Admin\Technicien;
use Illuminate\Http\Request;


class TechnicienController extends Controller
{
    public function index()
    {
        $notifs = Notification::where('user_id', 2)->get();
        $techniciens = User::where('role', 'technicien')->get();
        return view('admin.techniciens', compact('techniciens', 'notifs'));
    }
    public function destroy($id)
    {
        $technicien = Technicien::findOrFail($id);
        $technicien->delete();

        return redirect()->route('admin.admin.techniciens.index')->with('success', 'Technicien supprimé.');
    }
}






