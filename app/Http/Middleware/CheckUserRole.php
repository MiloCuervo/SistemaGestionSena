<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 1. validar usuario autenticado
        if (!$user) {
            return redirect()->route('login')->with('message', 'El usuario no pertenece al sistema!');
        }

        // 2. validar relación y role_id
        $user->loadMissing('configuration.role');

        if (!$user->configuration || !$user->configuration->role) { //se valida que el usuario tiene configuracion y que existe su rol 
            return redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}
