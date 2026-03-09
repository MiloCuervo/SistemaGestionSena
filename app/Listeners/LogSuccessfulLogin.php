<?php

namespace App\Listeners;

use App\Models\Login;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Support\Str;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     *
     * Registra el login exitoso en la tabla Logins,
     * capturando IP, user agent y sesión.
     */
    public function handle(LoginEvent $event): void
    {
        $request = request();

        Login::create([
            'id' => Str::uuid()->toString(),
            'user_id' => $event->user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => $request->session()->getId(),
            'logged_in_at' => now(),
        ]);
    }
}
