<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\cases;
use App\Models\Contact;
use App\Models\OrganizationProcess;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CasesController;

new class extends Component {

    use WithPagination;

    // Search and Filters
    public string $search = '';
    public string $statusFilter = '';

    // Modal state
    public bool $showModal = false;

    // Form fields for new case
    public string $type = 'request';
    public string $description = '';
    public string $status = 'in_progress';
    public $contact_id = '';
    public $organization_process_id = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset(['type', 'description', 'status', 'contact_id', 'organization_process_id']);
        $this->type = 'request';
        $this->status = 'in_progress';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function store()
    {
        $this->validate([
            'description' => 'required|string',
            'contact_id' => 'required|exists:contacts,id',
            'organization_process_id' => 'required|exists:organization_processes,id',
            'type' => 'required|string',
            'status' => 'nullable|string',
        ]);

        $type = $this->type === 'denunciation' ? 'complaint' : $this->type;

        $case = new cases();
        $case->case_number = "CAS-" . date("Ymd") . rand(1000, 9999);
        $case->description = $this->description;
        $case->status = $this->status ?? 'in_progress';
        $case->type = $type;
        $case->contact_id = $this->contact_id;
        $case->organization_process_id = $this->organization_process_id;
        $case->user_id = Auth::id();
        $case->save();

        $this->showModal = false;
        $this->reset(['type', 'description', 'status', 'contact_id', 'organization_process_id']);
        session()->flash('message', 'Caso creado correctamente.');
    }

    public function updateStatus($id, $newStatus)
    {
        $case = cases::where('user_id', Auth::id())->findOrFail($id);
        $case->status = $newStatus;
        $case->save();
        session()->flash('message', 'Estado actualizado correctamente.');
    }

    public function getTypeLabel(string $type): string
    {
        return match ($type) {
            'request' => 'Solicitud',
            'denunciation' => 'Denuncia',
            'complaint' => 'Denuncia',
            'right_of_petition' => 'Derecho de petición',
            'tutelage' => 'Tutela',
            default => $type ?: '—',
        };
    }

    public function getStatusBadge(string $status): array
    {
        return match ($status) {
            'in_progress' => ['label' => 'En proceso', 'classes' => 'bg-emerald-50 text-emerald-700', 'selectClasses' => 'bg-emerald-50 border-emerald-200', 'color' => '#065f46'],
            'attended' => ['label' => 'Atendido', 'classes' => 'bg-amber-50 text-amber-700', 'selectClasses' => 'bg-amber-50 border-amber-200', 'color' => '#92400e'],
            'not_attended' => ['label' => 'No atendido', 'classes' => 'bg-rose-50 text-rose-700', 'selectClasses' => 'bg-rose-50 border-rose-200', 'color' => '#9f1239'],
            default => ['label' => ucfirst(str_replace('_', ' ', $status)), 'classes' => 'bg-zinc-100 text-zinc-700', 'selectClasses' => 'bg-white border-zinc-300', 'color' => '#18181b'],
        };
    }

    public function with()
    {
        $query = cases::with(['contact', 'organizationProcess'])
            ->where('user_id', Auth::id());

        // Apply status filter
        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        // Apply search filter
        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('case_number', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        return [
            'cases' => $query->latest()->paginate(10),
            'contacts' => Contact::all(),
            'processes' => OrganizationProcess::all(),
        ];
    }
};
?>

<div class="space-y-6 ">
    {{-- Flash message --}}
    @if (session()->has('message'))
        <div class="rounded-md bg-emerald-50 p-4 text-sm text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400">
            {{ session('message') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Casos</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Listado de casos activos del usuario</p>
        </div>
    
    </div>

    {{-- Filters --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
        <div class="w-full sm:w-1/3">
            <input type="text" wire:model.live="search" placeholder="Buscar por número o descripción..."
                class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-900 focus:ring-zinc-900 hover:border-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:hover:border-zinc-300" />
        </div>
        <div class="w-full sm:w-1/4">   
        <select wire:model.live="statusFilter"
                class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-900 focus:ring-zinc-900 hover:border-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:hover:border-zinc-300">
                <option value="">Todos los estados</option>
                <option value="in_progress">En proceso</option>
                <option value="attended">Atendido</option>
                <option value="not_attended">No atendido</option>
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <div class="border-b border-zinc-200 px-6 py-4 dark:border-zinc-700">
            <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Casos activos</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full table-fixed divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th scope="col"
                            class="w-[140px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Radicado                        
                        </th>
                        <th scope="col"
                            class="w-[130px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Tipo
                        </th>
                        <th scope="col"
                            class="w-[180px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Descripción
                        </th>
                        <th scope="col"
                            class="w-[130px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Contacto
                        </th>
                        <th scope="col"
                            class="w-[170px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Proceso
                        </th>
                        <th scope="col"
                            class="w-[110px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Estado
                        </th>
                        <th scope="col"
                            class="w-[100px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100
                            dark:hover:bg-zinc-700">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                    @forelse ($cases as $caseItem)
                        @php
                            $badge = $this->getStatusBadge($caseItem->status ?? 'unknown');
                        @endphp
                        <tr>
                            <td class="w-[560px] px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                <p class="w-full truncate" title="{{ $caseItem->case_number ?? '' }}">
                                    {{ $caseItem->case_number ?? 'Sin número de radicado' }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-900 hover:bg-zinc-50 dark:text-white dark:hover:bg-zinc-800">
                                {{ $this->getTypeLabel($caseItem->type ?? '') }}
                            </td>
                            <td class="w-[560px] px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                <p class="w-full truncate" title="{{ $caseItem->description ?? '' }}">
                                    {{ $caseItem->description ?? 'Sin descripción' }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                {{ $caseItem->contact?->full_name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                {{ $caseItem->organizationProcess?->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <select wire:change="updateStatus({{ $caseItem->id }}, $event.target.value)"
                                    class="case-status-select w-full min-w-[90px] max-w-[120px] rounded-md border px-3 py-2 text-xs font-semibold shadow-sm focus:border-zinc-900 focus:ring-zinc-900 hover:border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:hover:bg-zinc-400 {{ $badge['selectClasses'] }}"
                                    style="color: {{ $badge['color'] }};">
                                    <option value="in_progress" @selected($caseItem->status === 'in_progress')>En proceso</option>
                                    <option value="attended" @selected($caseItem->status === 'attended')>Atendido</option>
                                    <option value="not_attended" @selected($caseItem->status === 'not_attended')>No atendido</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-wrap items-center">
                                    <a href="{{ route('user.cases.show', $caseItem->id) }}"
                                        class="inline-flex items-center rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-400">
                                        Ver
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                Todavía no hay casos activos para mostrar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($cases->hasPages())
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-700">
                {{ $cases->links() }}
            </div>
        @endif
    </div>

    <style>
        .case-status-select:focus {
            color: #000000;
        }

        .case-status-select option {
            color: #000000;
        }
    </style>
</div>
