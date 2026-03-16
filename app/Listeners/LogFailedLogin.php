<?php

namespace App\Listeners;

use App\Models\Login;
use Exception;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;

class LogFailedLogin
{
    /**
     * Handle the event.
     * Registra el login fallido en la tabla Logins,
     * capturando IP, user agent y sesión.
     */
    public function handle(Failed $event): void
    {
        try {
            if ($event->user) {
                $request = request();

                Login::create([
                    'user_id' => $event->user->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'session_id' => $request->session()->getId(),
                    'logged_in_at' => now(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error al registrar login: '.$e->getMessage());
        }
    }
}
