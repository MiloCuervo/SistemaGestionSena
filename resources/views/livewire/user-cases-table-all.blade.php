<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\cases;

new class extends Component {

    use WithPagination;

    // Search and Filters
    public string $search = '';
    public string $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
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
        $query = cases::with(['contact', 'organizationProcess', 'user']);

        // Apply status filter
        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter);
        }

        // Apply search filter
        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('case_number', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('name', 'like', "%{$this->search}%")
                            ->orWhere('last_name', 'like', "%{$this->search}%")
                            ->orWhere('second_name', 'like', "%{$this->search}%")
                            ->orWhere('second_last_name', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('contact', function ($contactQuery) {
                        $contactQuery->where('full_name', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('organizationProcess', function ($processQuery) {
                        $processQuery->where('name', 'like', "%{$this->search}%");
                    });
            });
        }

        return [
            'cases' => $query->latest()->paginate(10),
        ];
    }
};
?>

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Todos los casos</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Aqui puedes ver y acceder a la información detallada de todos los casos.</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
        <div class="w-full sm:w-1/3">
            <input type="text" wire:model.live="search" placeholder="Buscar por número, descripción o usuario..."
                class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-lime-500 focus:ring-lime-500 hover:border-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:hover:border-zinc-500 dark:focus:border-lime-400 dark:focus:ring-lime-400" />
        </div>
        <div class="w-full sm:w-1/4">
            <select wire:model.live="statusFilter"
                class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-lime-500 focus:ring-lime-500 hover:border-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:hover:border-zinc-500 dark:focus:border-lime-400 dark:focus:ring-lime-400">
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
                            class="w-[160px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Usuario
                        </th>
                        <th scope="col"
                            class="w-[130px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Tipo
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
                        <tr>
                            <td class="w-[560px] px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                <p class="w-full truncate" title="{{ $caseItem->case_number ?? '' }}">
                                    {{ $caseItem->case_number ?? 'Sin número de radicado' }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                {{ trim(($caseItem->user?->name ?? '') . ' ' . ($caseItem->user?->last_name ?? '')) ?: '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-zinc-900 hover:bg-zinc-50 dark:text-white dark:hover:bg-zinc-800">
                                {{ $this->getTypeLabel($caseItem->type ?? '') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                {{ $caseItem->contact?->full_name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                {{ $caseItem->organizationProcess?->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 hover:bg-zinc-50 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                {{ $this->getStatusLabel($caseItem->status ?? 'unknown') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                    <a href="{{ route('user.cases.show', $caseItem->id) }}"
                                        class="inline-flex items-center rounded-md border border-zinc-200 p-2 text-zinc-700 shadow-sm transition hover:border-lime-300 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:border-lime-500 dark:hover:bg-zinc-700"
                                        title="Ver caso" aria-label="Ver caso">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            <circle cx="12" cy="12" r="3" stroke-width="2" />
                                        </svg>
                                    </a>
                            </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
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
