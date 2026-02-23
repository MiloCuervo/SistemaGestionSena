<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\cases;
use App\Models\User;
use App\Models\OrganizationProcess;

new class extends Component {

    use WithPagination;

    public $users = [];
    public $processes = [];
    public function mount()
    {
        $this->users = User::whereHas('configuration', function ($query) {
            $query->where('role_id', 2);
        })->get();
        $this->processes = OrganizationProcess::all();
    }

    // Search and Filters
    public string $search = '';
    public string $statusFilter = '';
    public string $userFilter = '';
    public string $processFilter = '';

    // Modal state
    public bool $showModal = false;
    public $selectedCase = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingUserFilter()
    {
        $this->resetPage();
    }

    public function with()
    {
        $query = cases::query();

        // Apply status filter
        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->userFilter !== '') {
            $query->where('user_id', $this->userFilter);
        }

        if ($this->processFilter !== '') {
            $query->where('organization_process_id', $this->processFilter);
        }

        // Apply search filter
        if ($this->search !== '') {

            $query->where('case_number', 'like', "%{$this->search}%")
                ->orWhere('description', 'like', "%{$this->search}%")
                ->orWhere('status', 'like', "%{$this->search}%")
                ->orWhere('type', 'like', "%{$this->search}%")
                ->orWhere('created_by', 'like', "%{$this->search}%")
                ->orWhere('created_at', 'like', "%{$this->search}%")
                ->orWhere('contact_id', 'like', "%{$this->search}%")
                ->orWhere('organization_process_id', 'like', "%{$this->search}%");
        }

        // Return paginated results
        return [
            'cases' => $query->latest()->paginate(10),
        ];
    }

    public function viewCase($caseId)
    {
        $this->selectedCase = cases::findOrFail($caseId);
        return redirect()->route('admin.cases.show', $caseId);
    }
};
?>

<div class="mt-10 space-y-6">
    <flux:heading size="xl" level="1">{{ __('Cases Management') }}</flux:heading>

    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <div class="w-full sm:w-1/3">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search by field..." />
        </div>
        <flux:dropdown>
            <flux:button icon:trailing="chevron-down">{{ __('Filters') }}</flux:button>

            <flux:menu>
                <flux:menu.submenu heading="{{ __('States') }}">
                    <flux:select wire:model.live="statusFilter" placeholder="{{ __('Status') }}">
                        <flux:select.option value="">{{ __('All statuses') }}</flux:select.option>
                        <flux:select.option value="attended">{{ __('actions.attended') }}</flux:select.option>
                        <flux:select.option value="in_progress">{{ __('actions.in_progress') }}</flux:select.option>
                        <flux:select.option value="not_attended">{{ __('actions.not_attended') }}</flux:select.option>
                    </flux:select>
                </flux:menu.submenu>

                <flux:menu.submenu heading="{{ __('Commissioners') }}">
                    <flux:select wire:model.live="userFilter">
                        <flux:select.option value="">{{ __('All Commissioners') }}</flux:select.option>
                        @foreach($users as $user)
                            <flux:select.option value="{{ $user->id }}">{{ $user->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:menu.submenu>

                <flux:menu.submenu heading="{{ __('Processes') }}">
                    <flux:select wire:model.live="processFilter">
                        <flux:select.option value="">{{ __('All Processes') }}</flux:select.option>
                        @foreach($processes as $process)
                            <flux:select.option value="{{ $process->id }}">{{ $process->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:menu.submenu>

            </flux:menu>
        </flux:dropdown>
    </div>

    <!-- Table -->
    <flux:table :paginate="$cases">
        <flux:table.columns>
            <flux:table.column>{{ __('Field') }}</flux:table.column>
            <flux:table.column>{{ __('Description') }}</flux:table.column>
            <flux:table.column>{{ __('Status') }}</flux:table.column>
            <flux:table.column>{{ __('Type') }}</flux:table.column>
            <flux:table.column>{{ __('Created by') }}</flux:table.column>
            <flux:table.column>{{ __('Created') }}</flux:table.column>
            <flux:table.column>{{ __('Contact') }}</flux:table.column>
            <flux:table.column>{{ __('Organization Process') }}</flux:table.column>
            <flux:table.column>{{ __('Closed') }}</flux:table.column>
            <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse($cases as $case)
                <flux:table.row :key="$case->id">
                    <flux:table.cell class="font-medium">{{ $case->case_number }}</flux:table.cell>
                    <flux:table.cell class="font-medium">{{ Str::limit($case->description, 50) }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:badge variant="ghost" size="sm">
                            {{ __('actions.' . $case->status) }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap text-gray-500">
                        {{ __('actions.' . $case->type) }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap text-gray-500">
                        {{ $case->user->name }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap text-gray-500">
                        {{ \Carbon\Carbon::parse($case->created_at)->format('M d, Y') }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap text-gray-500">
                        {{ $case->contact->full_name ?? 'N/A' }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap text-gray-500">
                        {{ $case->organizationProcess->name ?? 'N/A' }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap text-gray-500 text-center">
                        @if($case->status === 'closed')
                            <flux:badge color="emerald" icon="check" variant="ghost" size="sm">Si</flux:badge>
                        @else
                            <flux:text color="red" variant="subtle">No</flux:text>
                        @endif
                    </flux:table.cell>

                    <flux:table.cell align="end">
                        <div class="flex justify-end gap-2">
                            <flux:button size="sm" variant="ghost" icon="eye" title="Ver caso"
                                wire:click="viewCase({{ $case->id }})" />
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center py-10">
                        <flux:text variant="subtle">No se encontraron casos.</flux:text>
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>