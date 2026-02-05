<?php

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\cases;

new class extends Component {

    // Event listener to refresh stats
    #[On('caseUpdated')]
    public function refreshStats()
    {
        // 
    }

    // Computed properties for stats and recent cases
    #[Computed]
    public function stats()
    {
        return [
            'attended' => cases::where('status', 'attended')->count(),
            'pending' => cases::where('status', 'pending')->count(),
            'not_attended' => cases::where('status', 'not_attended')->count(),
            'closed' => cases::where('status', 'closed')->count(),
            'total' => cases::count(),
        ];
    }

    // Recently edited cases
    #[Computed]
    public function recentCases()
    {
        return cases::latest()->take(5)->get();
    }
};
?>


<div class="bg-white dark:bg-gray-900 rounded-xl shadow p-8">

    <dl class="grid grid-cols-1 gap-x-8 gap-y-10 text-center sm:grid-cols-2 lg:grid-cols-5">

        <!-- Attended -->
        <div class="mx-auto flex max-w-xs flex-col gap-y-2">
            <dt class="text-sm text-gray-500 dark:text-gray-400">
                Attended
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->stats['attended'] }}
            </dd>
        </div>

        <!-- Pending -->
        <div class="mx-auto flex max-w-xs flex-col gap-y-2">
            <dt class="text-sm text-gray-500 dark:text-gray-400">
                Pending
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->stats['pending'] }}
            </dd>
        </div>

        <!-- Not Attended -->
        <div class="mx-auto flex max-w-xs flex-col gap-y-2">
            <dt class="text-sm text-gray-500 dark:text-gray-400">
                Not Attended
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->stats['not_attended'] }}
            </dd>
        </div>

        <!-- Closed -->
        <div class="mx-auto flex max-w-xs flex-col gap-y-2">
            <dt class="text-sm text-gray-500 dark:text-gray-400">
                Closed
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->stats['closed'] }}
            </dd>
        </div>

        <!-- Total -->
        <div class="mx-auto flex max-w-xs flex-col gap-y-2">
            <dt class="text-sm text-gray-500 dark:text-gray-400">
                Total Cases
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->stats['total'] }}
            </dd>
        </div>

    </dl>
</div>