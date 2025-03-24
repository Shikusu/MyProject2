<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Vérifier si l'utilisateur est authentifié
        if (Auth::check()) {
            $user = Auth::user();

            // Liste des redirections possibles selon le rôle
            $redirects = [
                'technicien' => route('technicien.dashboard'),
                'admin' => route('admin.dashboard'),  // Ajouter une redirection pour les admins si nécessaire
                // Vous pouvez ajouter d'autres rôles ici si besoin
            ];

            // Vérifier si le rôle de l'utilisateur correspond au rôle requis pour cette route
            if ($user->role !== $role) {
                // Rediriger l'utilisateur vers la page appropriée en fonction de son rôle
                if (isset($redirects[$user->role])) {
                    return redirect($redirects[$user->role]);
                }

                // Sinon, retourner un message d'accès interdit
                return response()->json([
                    'message' => 'Accès interdit. Vous n\'avez pas les permissions nécessaires pour accéder à cette ressource.',
                    'user_role' => $user->role,
                    'required_role' => $role
                ], 403);
            }

            // Si le rôle est correct, autoriser l'accès à la ressource
            return $next($request);
        }

        // Si l'utilisateur n'est pas authentifié, rediriger vers la page de connexion
        return redirect()->route('login.form');
    }
}

