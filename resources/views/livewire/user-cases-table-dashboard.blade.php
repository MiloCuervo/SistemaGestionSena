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

        $case = new cases();
        $case->case_number = "CAS-" . date("Ymd") . rand(1000, 9999);
        $case->description = $this->description;
        $case->status = $this->status ?? 'in_progress';
        $case->type = $this->type;
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

<div class="space-y-6">
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

        <button type="button" wire:click="openModal"
            class="inline-flex items-center justify-center rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-400">
            Agregar caso
        </button>
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

    {{-- Create Case Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 z-[999] flex items-center justify-center bg-zinc-900/50 p-4" wire:click.self="closeModal">
            <div
                class="w-full max-w-sm rounded-lg border border-zinc-200 bg-white p-0 shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                <form wire:submit="store" class="p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Nuevo caso</h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Completa la información del caso.</p>
                        </div>
                        <button type="button" wire:click="closeModal"
                            class="rounded-md border border-transparent p-2 text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-600 dark:hover:bg-zinc-800 dark:hover:text-zinc-200">
                            Cerrar
                        </button>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4">
                        <div>
                            <label for="case_type" class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Tipo
                                de caso</label>
                            <select id="case_type" wire:model="type"
                                class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                required>
                                <option value="request">Solicitud</option>
                                <option value="denunciation">Denuncia</option>
                                <option value="right_of_petition">Derecho de petición</option>
                                <option value="tutelage">Tutela</option>
                            </select>
                            @error('type') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="case_description"
                                class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Descripción</label>
                            <textarea id="case_description" wire:model="description" rows="3"
                                class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                placeholder="Describe el caso..." required></textarea>
                            @error('description') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="case_status"
                                class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Estado</label>
                            <select id="case_status" wire:model="status"
                                class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                <option value="in_progress">En proceso</option>
                                <option value="attended">Atendido</option>
                                <option value="not_attended">No atendido</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="case_contact"
                                    class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Contacto</label>
                                <select id="case_contact" wire:model="contact_id"
                                    class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                    required>
                                    <option value="" selected disabled>Selecciona un contacto</option>
                                    @foreach ($contacts as $contact)
                                        <option value="{{ $contact->id }}">{{ $contact->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('contact_id') <span class="text-xs text-rose-500">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="case_process"
                                    class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Proceso</label>
                                <select id="case_process" wire:model="organization_process_id"
                                    class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                    required>
                                    <option value="" selected disabled>Selecciona un proceso</option>
                                    @foreach ($processes as $process)
                                        <option value="{{ $process->id }}">{{ $process->name }}</option>
                                    @endforeach
                                </select>
                                @error('organization_process_id') <span class="text-xs text-rose-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                        <button type="button" wire:click="closeModal"
                            class="inline-flex justify-center rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="inline-flex justify-center rounded-md bg-zinc-900 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <style>
        .case-status-select:focus {
            color: #000000;
        }

        .case-status-select option {
            color: #000000;
        }
    </style>
</div>

