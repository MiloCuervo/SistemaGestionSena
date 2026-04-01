<?php 

namespace App\Services\Users;

use App\Models\Cases;
use App\Models\OrganizationProcess;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminService
{
    public function getReportStats()
    {   
        // Total de casos en el sistema
        $totalCases = Cases::count();

        // Casos activos (sin cerrar y sin resolver)
        $activeCases = Cases::whereNull('closed_date')
            ->orWhere(function ($query) {
                $query->where('closed_date', '>', now())
                      ->where('status', '!=', 'attended');
            })
            ->count();

        // Casos vencidos (pasaron la fecha de cierre y no los atendieron)
        $overdueCases = Cases::where('closed_date', '<', now())
            ->where('status', '!=', 'attended')
            ->count();

        // Top 2 Comisionados con más casos
        $topCommissioners = User::withCount('cases')
            ->orderByDesc('cases_count')
            ->take(2)
            ->get();

        // Top 2 Procesos con más casos
        $topProcesses = OrganizationProcess::withCount('cases')
            ->orderByDesc('cases_count')
            ->take(2)
            ->get();

        // Casos creados hoy
        $casesToday = Cases::whereDate('created_at', today())->count();

        // Casos cerrados (status = 'attended')
        $closedCases = Cases::where('status', 'attended')->count();
        
        // Se compactan todas las variables para solo enviar un $data a la vista
        $data = compact(
            'totalCases',
            'activeCases',
            'overdueCases',
            'topCommissioners',
            'topProcesses',
            'casesToday',
            'closedCases'
        );

        return $data;
    }


}