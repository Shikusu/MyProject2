<?php
namespace App\Http;

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // Autres middlewares...
        'role' => RoleMiddleware::class,  // Enregistrement du middleware 'role'
    ];
}
