<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Admin\Alerte;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $technicienId = Auth::user()->id;
                $notificationsCount  = Alerte::count();
                $view->with('notificationsCount', $notificationsCount);
            }
        });
    }
}
