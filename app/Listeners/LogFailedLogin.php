<?php

namespace App\Listeners;

use App\Models\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Str;

class LogFailedLogin
{
    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        if ($event->user) {
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
}
