<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roleId): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        // Obtener la configuración del usuario (asumiendo la primera como la activa)
        $config = $user->configuration->first();

        // Convertir roleId a entero para la comparación segura
        if (!$config || $config->role_id != (int) $roleId) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
