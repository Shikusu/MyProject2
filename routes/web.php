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
use App\Http\Controllers\Technicien\TechnicianController;
use App\Http\Controllers\Technicien\TechnicianEmetteurController;
use App\Http\Controllers\Technicien\HistoriqueController;

// 🏠 Redirection selon le rôle de l'utilisateur après connexion
Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'technicien' => redirect()->route('technicien.dashboard'),
            default => redirect()->route('login.form'),
        };
    }
    return redirect()->route('login.form');
});

// 🔑 Routes pour les invités (non authentifiés)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});

// 🚪 Route de déconnexion (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🛠 Routes pour l'admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // 🚨 Alertes
    Route::prefix('alertes')->name('alertes.')->group(function () {
        Route::get('/', [AlerteController::class, 'index'])->name('index');
        Route::post('/', [AlerteController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AlerteController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlerteController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlerteController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/resolve', [AlerteController::class, 'resolve'])->name('resolve');
        Route::put('/{id}/inprogress', [AlerteController::class, 'inProgress'])->name('inprogress');
    });

    // 🚨 Interventions
Route::prefix('interventions')->name('interventions.')->group(function () {
    Route::get('/', [InterventionController::class, 'index'])->name('index');
    Route::post('/', [InterventionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [InterventionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [InterventionController::class, 'update'])->name('update');
    Route::delete('/{id}', [InterventionController::class, 'destroy'])->name('destroy');
    Route::post('/declencher-panne/{id}', [InterventionController::class, 'declencherPanne'])->name('declencherPanne');
});


    // 🏠 Localisations
    Route::prefix('localisations')->name('localisations.')->group(function () {
        Route::get('/', [LocalisationController::class, 'index'])->name('index');
        Route::get('create', [LocalisationController::class, 'create'])->name('create');
        Route::post('/', [LocalisationController::class, 'store'])->name('store');
        Route::get('{id}/edit', [LocalisationController::class, 'edit'])->name('edit');
        Route::put('{id}', [LocalisationController::class, 'update'])->name('update');
        Route::delete('{id}', [LocalisationController::class, 'destroy'])->name('destroy');
    });

    // 🧩 Pièces
    Route::prefix('pieces')->name('pieces.')->group(function () {
        Route::get('/', [PieceController::class, 'index'])->name('index');
        Route::post('/', [PieceController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        Route::get('/{id}/edit', [PieceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PieceController::class, 'update'])->name('update');
        Route::delete('/{id}', [PieceController::class, 'destroy'])->name('destroy');
    });

    // 📡 Émetteurs
    Route::prefix('emetteurs')->name('emetteurs.')->group(function () {
        Route::get('/', [EmetteurController::class, 'index'])->name('index');
        Route::post('/', [EmetteurController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [EmetteurController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EmetteurController::class, 'update'])->name('update');
        Route::delete('/{id}', [EmetteurController::class, 'destroy'])->name('destroy');
    });
});

// 🛠 Routes pour les techniciens
Route::middleware(['auth', 'role:technicien'])->prefix('technicien')->name('technicien.')->group(function () {
    Route::get('/', [TechnicianController::class, 'dashboard'])->name('dashboard');
    Route::get('/emetteurs', [TechnicianController::class, 'emetteurs'])->name('emetteurs');

    // Route pour afficher l'historique des interventions
    Route::get('/historiques', [HistoriqueController::class, 'index'])->name('historiques');

    // Route pour supprimer les interventions sélectionnées
    Route::post('/intervention/supprimer', [HistoriqueController::class, 'deleteSelectedInterventions'])->name('intervention.supprimer');

    Route::get('/declencher-panne/{id}', [TechnicianController::class, 'declencherPanne'])->name('declencherPanne');
    Route::get('/reparations/{id}', [TechnicianController::class, 'reparations'])->name('reparations');
    Route::post('/reparations/{id}', [TechnicianController::class, 'saveRepair'])->name('saveRepair');

    // Nouvelle route pour afficher l'intervention avec les pièces
    Route::get('/intervention/{id}', [TechnicianController::class, 'showInterventionForm'])->name('intervention.show');
});

