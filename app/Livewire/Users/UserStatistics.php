<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Computed;

class UserStatistics extends Component
{
    public User $user;

    /**
     * Contar el total de casos registrados por el usuario
     */
    #[Computed]
    public function casesCount()
    {
        return $this->user->cases()->count();
    }

    /**
     * Obtener los últimos 3 casos registrados por el usuario
     */
    #[Computed]
    public function latestCases()
    {
        $cases= $this->user->cases()
            ->latest('created_at')
            ->limit(3)
            ->get();
        if($cases->isEmpty()){
            return $cases = [];
        }
        return $cases;
    }

    /**
     * Contar sesiones del mes actual
     */
    #[Computed]
    public function sessionsThisMonth()
    {
        return $this->user->logins()
            ->whereMonth('logged_in_at', now()->month)
            ->whereYear('logged_in_at', now()->year)
            ->count();
    }

    /**
     * Obtener la última sesión del usuario
     */
    #[Computed]
    public function lastSessionDate()
    {
        return $this->user->logins()
            ->latest('logged_in_at')
            ->first()
            ?->logged_in_at?->diffForHumans() ?? 'N/A';
    }

    /**
     * Obtener todas las sesiones para mostrar en la tabla
     */
    #[Computed]
    public function logins()
    {
        return $this->user->logins()
            ->latest('logged_in_at')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.users.user-statistics');
    }
}
