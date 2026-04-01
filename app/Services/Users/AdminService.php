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

    public function getDashboardStats()
    {
        // 1. Datos para el gráfico de estados (Donut)
        $statusCounts = Cases::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $statusData = [
            'series' => [
                $statusCounts->get('attended', 0),
                $statusCounts->get('in_progress', 0),
                $statusCounts->get('not_attended', 0),
            ],
            'labels' => ['attended', 'in_progress', 'not_attended'],
        ];

        // 2. Datos para el gráfico de comisionados (Barra Horizontal)
        $commissioners = User::whereHas('configuration', fn ($q) => $q->where('role_id', 2))
            ->withCount(['cases as value'])
            ->having('value', '>', 0)
            ->orderByDesc('value')
            ->get(['name'])
            ->toArray();

        // 3. Datos para el gráfico mensual (Barra)
        $monthlyCases = Cases::select(
            DB::raw('MONTH(created_at) as month'),
            'status',
            DB::raw('count(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'status')
            ->get();

        $monthlySeries = [
            'attended' => array_fill(1, 12, 0),
            'in_progress' => array_fill(1, 12, 0),
            'not_attended' => array_fill(1, 12, 0),
        ];

        foreach ($monthlyCases as $case) {
            if (isset($monthlySeries[$case->status][$case->month])) {
                $monthlySeries[$case->status][$case->month] = $case->count;
            }
        }

        $monthlyData = [
            'attended' => array_values($monthlySeries['attended']),
            'in_progress' => array_values($monthlySeries['in_progress']),
            'not_attended' => array_values($monthlySeries['not_attended']),
        ];

        // 4. Total de casos
        $total = array_sum($statusData['series']);

        // Consolidar todos los datos para la vista
        return [
            'total' => $total,
            'status' => $statusData,
            'commissioners' => $commissioners,
            'monthly' => $monthlyData,
        ];
    }


}