<?php

namespace App\Listeners;

use App\Models\Login;
use Illuminate\Auth\Events\Logout;

class LogLogout
{
    public function handle(Logout $event): void
    {
        // Actualizar el registro de login activo para esta sesión
        Login::where('user_id', $event->user->id)
            ->where('session_id', session()->getId())
            ->whereNull('logged_out_at')
            ->update(['logged_out_at' => now()]);
    }
}
