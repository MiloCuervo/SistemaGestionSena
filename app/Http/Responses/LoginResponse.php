<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = Auth::user();

        // Obtener la configuración del usuario para verificar su rol
        $config = $user->configuration->first();

        // Verificar si existe configuración
        if ($config) {
            // Redirección basada en el ID del rol
            // 1: Admin 
            if ($config->role_id === 1) {
                return redirect()->route('admin.dashboard');
            }

            // 2: Comisionado 
            if ($config->role_id === 2) {
                return redirect()->route('user.dashboard');
            }
        }
        Auth::logout();

        return redirect()->route('login')->withErrors([
            'email' => 'El usuario no tiene un rol asignado para acceder al sistema.',
        ]);
    }
}
