<?php

use Livewire\Component;
use App\Models\cases;
use App\Http\Controllers\CasesController;
use Livewire\Attributes\Computed;

new class extends Component
{
    public $myChart = [
        'type' => 'bar',
        'data' => [
            'labels' => ['Atendidos', 'En progreso', 'No atendidos'],
            'datasets' => [
                [
                    'label' => 'Casos',
                    'data' => [0, 0, 0],
                    'backgroundColor' => [
                        'rgba(118, 214, 56, 0.5)',
                        'rgba(58, 104, 138, 0.5)',
                        'rgba(63, 63, 70, 0.5)'
                    ],
                    'borderColor' => [
                        'rgba(118, 214, 56, 1)',
                        'rgba(58, 104, 138, 1)',
                        'rgba(63, 63, 70, 1)'
                    ],
                    'borderWidth' => 4
                ]
            ],
        ],
        'options' => [
            'plugins' => [
                    'legend' => [
                        'display' => false,
                        'position' => 'top',
                    ],
                    'title' => [
                        'display' => false,
                        
                    ],
            ],
            'indexAxis' => 'y',
             'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1
                    ]
                ]
            ]
        ],
    ];

    public function mount()
    {
        $this->loadChart();
    }

    public function loadChart()
    {
        $casesAttended = Cases::where('status', 'attended')->count();
        $casesInProgress = Cases::where('status', 'in_progress')->count();
        $casesNotAttended = Cases::where('status', 'not_attended')->count();

        $this->myChart['data']['datasets'][0]['data'] = [
            $casesAttended,
            $casesInProgress,
            $casesNotAttended
        ];
    }

};
?>

<div>
    <x-chart wire:model="myChart" />
</div>
