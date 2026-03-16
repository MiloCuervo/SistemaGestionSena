<?php

namespace App\Listeners;

use App\Actions\Login\UpdateLogoutAction;
use App\Models\Login;
use Exception;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;

class LogLogout
{
    private UpdateLogoutAction $updateLogoutAction;

    public function __construct(UpdateLogoutAction $updateLogoutAction)
    {
        $this->updateLogoutAction = $updateLogoutAction;
    }

    /**
     * Handle the event.
     * Registra el logout en la tabla Logins,
     * capturando IP, user agent y sesión.
     */
    public function handle(Logout $event): void
    {
        try {// Actualizar el registro de login activo para esta sesión
            $criteria = [
                'user_id' => $event->user->id,
                'session_id' => session()->getId(),
            ];

            $this->updateLogoutAction->execute($criteria);
        } catch (Exception $e) {
            Log::error('Error al registrar logout: '.$e->getMessage());
        }
    }
}
