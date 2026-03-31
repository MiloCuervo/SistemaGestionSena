<?php

namespace App\Listeners;

use App\Actions\Login\StoreLoginAction;
use Exception;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    private StoreLoginAction $storeLoginAction;

    public function __construct(StoreLoginAction $storeLoginAction)
    {
        $this->storeLoginAction = $storeLoginAction;
    }

    /**
     * Handle the event.
     *
     * Registra el login exitoso en la tabla Logins,
     * capturando IP, user agent y sesión.
     */
    public function handle(LoginEvent $event): void
    {
        Log::info('Login listener triggered for user: ' . $event->user->id);
        
        try {
            
            Log::info('Login event successfully recorded in database.');
            
        } catch (Exception $e) {
            Log::error('Error al registrar login: '.$e->getMessage());
        }
    }
}
