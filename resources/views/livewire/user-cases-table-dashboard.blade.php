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

    public function getTypeLabel(string $type): string
    {
        return match ($type) {
            'request' => 'Solicitud',
            'denunciation' => 'Denuncia',
            'complaint' => 'Queja',
            'right_of_petition' => 'Derecho de petición',
            'tutelage' => 'Tutela',
            default => $type ?: '—',
        };
    }

    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'in_progress' => 'En proceso',
            'attended' => 'Atendido',
            'not_attended' => 'No atendido',
            default => $status ?: 'Desconocido',
        };
    }

    public function with()
    {
        $query = cases::with(['contact', 'organizationProcess'])
            ->where('user_id', Auth::id())
            ->active();

        // Apply status filter
        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        // Apply search filter
        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('case_number', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhere('sena_number', 'like', "%{$this->search}%");
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
                            class="w-[105px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Radicado                        
                        </th>
                        <th scope="col"
                            class="w-[95px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Tipo
                        </th>
                        <th scope="col"
                            class="w-[130px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Descripción
                        </th>
                        <th scope="col"
                            class="w-[100px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Contacto
                        </th>
                        <th scope="col"
                            class="w-[115px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Proceso
                        </th>
                        <th scope="col"
                            class="w-[100px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
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
                                <td class="px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                {{ $caseItem->status ? $this->getStatusLabel($caseItem->status) : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                                    <a href="{{ route('user.cases.show', $caseItem->id) }}"
                                        class="w-full sm:w-auto rounded-md border border-zinc-200 p-2 text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-400"
                                        title="Ver caso" aria-label="Ver caso">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <circle cx="12" cy="12" r="3" stroke-width="2" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('user.cases.status.edit', $caseItem->id) }}"
                                        class="w-full sm:w-auto rounded-md border border-zinc-200 p-2 text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-400"
                                        title="Modificar estado" aria-label="Modificar estado">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 22v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('user.cases.deactivate', $caseItem->id) }}"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este caso?');"
                                        class="w-full sm:w-auto">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="w-full sm:w-auto rounded-md border border-red-200 p-2 text-red-700 shadow-sm transition hover:bg-red-50 dark:border-red-700 dark:text-red-200 dark:hover:bg-red-500/20"
                                            title="Eliminar caso" aria-label="Eliminar caso">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
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

</div>
