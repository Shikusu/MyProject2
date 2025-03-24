<?php

// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Middleware\RoleMiddleware;  // Importation du middleware

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Enregistrer les services nécessaires ici, si besoin
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Assurer une longueur par défaut pour les colonnes de type string dans la base de données
        Schema::defaultStringLength(191);

        // Enregistrer le middleware 'role' sans Kernel.php
        Route::aliasMiddleware('role', RoleMiddleware::class);
    }
}

