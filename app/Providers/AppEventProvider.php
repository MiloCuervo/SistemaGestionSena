<?php

namespace App\Providers;

use App\Listeners\LogFailedLogin;
use App\Listeners\LogLogout;
use App\Listeners\LogSuccessfulLogin;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Login exitoso
        Login::class => [
            LogSuccessfulLogin::class,
        ],

        // Login fallido
        Failed::class => [
            LogFailedLogin::class,
        ],

        // Logout exitoso
        Logout::class => [
            LogLogout::class,
        ],
    ];
}
