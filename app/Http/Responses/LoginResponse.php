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
        $role = $user->configuration?->role_id;

        // Verificar si existe configuración
        switch ($role) {
            case 1:
                return redirect()->route('admin.dashboard');
                break;
            case 2:
                return redirect()->route('user.dashboard');
                break;
            default:
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'El usuario no tiene un rol   asignado para acceder al sistema.',
                ]);
                break;
        }
    }
}
