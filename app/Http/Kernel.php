<?php

namespace App\Http;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'role' => RoleMiddleware::class,
        'prevent' => PreventBackHistory::class,
    ];
}
