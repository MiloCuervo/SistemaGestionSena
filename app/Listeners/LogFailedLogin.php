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
        Log::info('Failed login listener triggered for user: ' . ($event->user ? $event->user->id : 'unknown user'));
    }
}
