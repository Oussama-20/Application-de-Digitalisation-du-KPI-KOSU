<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            abort(403, 'Accès non autorisé');
        }

        $userRole = strtolower(trim(auth()->user()->role));
        $requiredRole = strtolower(trim($role));

        if ($userRole !== $requiredRole) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}