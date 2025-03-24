<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Middleware\RoleMiddleware;

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Routes protégées par rôle
Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return response()->json(['message' => 'Welcome Admin']);
    });
});

Route::middleware([RoleMiddleware::class . ':technicien'])->group(function () {
    Route::get('/technicien-dashboard', function () {
        return response()->json(['message' => 'Welcome Technicien']);
    });
});
