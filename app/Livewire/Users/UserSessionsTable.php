<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Computed;

class UserSessionsTable extends Component
{
    public User $user;

    /**
     * Obtener todas las sesiones del usuario
     */
    #[Computed]
    public function logins()
    {
        return $this->user->logins()
            ->latest('logged_in_at')
            ->get();
    }

    /**
     * Obtener información del navegador desde el user_agent
     */
    public function getBrowserInfo($userAgent)
    {
        if (str_contains($userAgent, 'Chrome')) {
            return 'Chrome';
        } elseif (str_contains($userAgent, 'Firefox')) {
            return 'Firefox';
        } elseif (str_contains($userAgent, 'Safari')) {
            return 'Safari';
        } elseif (str_contains($userAgent, 'Edge')) {
            return 'Edge';
        } else {
            return 'Desconocido';
        }
    }

    /**
     * Calcular duración de la sesión en minutos
     */
    public function getSessionDuration($loggedIn, $loggedOut)
    {
        if (!$loggedOut) {
            return null;
        }

        return $loggedIn->diffInMinutes($loggedOut);
    }

    public function render()
    {
        return view('livewire.users.user-sessions-table');
    }
}
