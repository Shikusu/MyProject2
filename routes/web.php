<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PieceController;
use App\Http\Controllers\Admin\LocalisationController;
use App\Http\Controllers\Admin\EmetteurController;
use App\Http\Controllers\Admin\AlerteController;
use App\Http\Controllers\Admin\InterventionController;
use App\Http\Controllers\Admin\TechnicienController;
use App\Http\Controllers\Technicien\TechnicianController;
use App\Http\Controllers\Technicien\HistoriqueController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Technicien\ProfileController; // Pour technicien
use App\Http\Controllers\Admin\ProfileController as AdminProfileController; // Pour admin
use App\Http\Controllers\Admin\DashboardController; // Bien importer le DashboardController

// 🏠 Redirection selon le rôle de l'utilisateur après connexion
Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'technicien' => redirect()->route('technicien.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

// 🔑 Routes pour les invités (non authentifiés)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});

// 🚪 Route de déconnexion (POST)
Route::post('/logout', [AuthController::class, 'logout'])->middleware('prevent')->name('logout');

// 🛠 Routes pour l'admin
Route::middleware(['auth', 'role:admin', 'prevent'])->prefix('admin')->name('admin.')->group(function () {
    // Page d'accueil admin (dashboard)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard spécifique avec DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🚨 Alertes
    Route::resource('alertes', AlerteController::class);

    // 🚨 Interventions
    Route::resource('interventions', InterventionController::class);
    Route::post('/interventions/declencher-panne/{id}', [InterventionController::class, 'declencherPanne'])->name('interventions.declencherPanne');

    // 👨‍🔧 Gestion des techniciens
    Route::get('/techniciens', [TechnicienController::class, 'index'])->name('techniciens.index');
    Route::delete('/techniciens/{id}', [TechnicienController::class, 'destroy'])->name('techniciens.destroy');

    // 🏠 Localisations
    Route::resource('localisations', LocalisationController::class);

    // 🧩 Pièces
    Route::resource('pieces', PieceController::class);

    // 📡 Émetteurs
    Route::resource('emetteurs', EmetteurController::class);

    // 🏢 Stations
    Route::get('/stations', [StationController::class, 'index'])->name('stations.index');

    // 👤 Profil admin
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/updateProfile', [AdminProfileController::class, 'updateProfile'])->name('profile.updateProfile');
    Route::put('/profile/updatePassword', [AdminProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

// 🛠 Routes pour les techniciens
Route::middleware(['auth', 'role:technicien', 'prevent'])->prefix('technicien')->name('technicien.')->group(function () {
    Route::get('/', [TechnicianController::class, 'dashboard'])->name('dashboard');
    Route::get('/emetteurs', [TechnicianController::class, 'emetteurs'])->name('emetteurs');
    Route::get('/historiques', [HistoriqueController::class, 'index'])->name('historiques');
    Route::post('/intervention/supprimer', [HistoriqueController::class, 'deleteSelectedInterventions'])->name('intervention.supprimer');
    Route::get('/declencher-panne/{id}', [TechnicianController::class, 'declencherPanne'])->name('declencherPanne');
    Route::get('/reparations/{id}', [TechnicianController::class, 'reparations'])->name('reparations');
    Route::post('/reparations/{id}', [TechnicianController::class, 'saveRepair'])->name('saveRepair');
    Route::get('/intervention/{id}', [TechnicianController::class, 'showInterventionForm'])->name('intervention.show');

    // 👤 Profil technicien
    Route::get('/profil', [TechnicianController::class, 'profil'])->name('profil');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/updateProfile', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
});

// 📦 Réparation lancée (accessible admin)
Route::post('/interventions/{id}/lancement-reparation', [InterventionController::class, 'lancementReparation'])->name('admin.interventions.lancementReparation');

// 🔔 Marquer une notification comme lue
Route::post('/notifications/mark-as-read/{id}', [TechnicianController::class, 'markAsRead']);
