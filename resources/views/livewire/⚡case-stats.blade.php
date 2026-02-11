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

    public function totalCases(){
        return cases::count();
    }
    public function GetAttendedCases(){
        return cases::where('status', 'attended')->get();
    }

    public function GetInProgressCases(){
        return cases::where('status', 'in_progress')->get();    
    }

    public function GetNotAttendedCases(){
        return cases::where('status', 'not_attended')->get();    
    }
    public function GetClosedCases(){
        return cases::where('status', 'closed')->get();    
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
                {{ __('Attended') }}
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->GetAttendedCases()->count() }}
            </dd>
        </div>

        <!-- Pending -->
        <div class="mx-auto flex max-w-xs flex-col gap-y-2">
            <dt class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('In Progress') }}
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->GetInProgressCases()->count() }}
            </dd>
        </div>

        <!-- Not Attended -->
        <div class="mx-auto flex max-w-xs flex-col gap-y-2">
            <dt class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Not attended') }}
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->GetNotAttendedCases()->count() }}
            </dd>
        </div>

        <!-- Closed -->
        <div class="mx-auto flex max-w-xs flex-col gap-y-2">
            <dt class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Closed') }}
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->GetClosedCases()->count() }}
            </dd>
        </div>

        <!-- Total -->
        <div class="mx-auto flex max-w-xs flex-col gap-y-2">
            <dt class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Total Cases') }}
            </dt>
            <dd class="order-first text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">
                {{ $this->totalCases() }}
            </dd>
        </div>

    </dl>
</div>