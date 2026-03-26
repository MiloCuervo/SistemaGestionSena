<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\OrganizationProcess;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $search = '';

    #[Computed]
    public function processes()
    {
        return OrganizationProcess::withCount('cases')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();
    }
};
?>

<div class="py-8">
    <div class="space-y-8">
        <div class="flex flex-col gap-2">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">PROCESOS DEL SISTEMA
            </h1>
            <hr class="border-zinc-200 dark:border-zinc-800" />
        </div>
        
        <!-- Header con Búsqueda y Botón Crear -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 py-4">
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model.live="search" type="search" placeholder="Buscar procesos..." 
                       class="block w-full pl-10 pr-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white focus:border-transparent focus:text-dar sm:text-sm transition-colors shadow-sm" />
            </div>

            <button x-data x-on:click="$dispatch('open-modal', 'create-process')" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-lg font-medium text-sm hover:bg-zinc-800 dark:hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-900 dark:focus:ring-white transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Crear Proceso
            </button>
        </div>

        <!-- Tabla de Procesos -->
        <div class="overflow-x-auto overflow-y-hidden border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm w-full">
            <table class="w-full min-w-full divide-y divide-zinc-200 dark:divide-zinc-800 text-left">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th scope="col" class="w-1/4 px-6 py-4 text-sm font-semibold text-zinc-900 dark:text-zinc-100 whitespace-nowrap">Nombre</th>
                        <th scope="col" class="w-2/4 px-6 py-4 text-sm font-semibold text-zinc-900 dark:text-zinc-100 whitespace-nowrap">Descripción</th>
                        <th scope="col" class="px-6 py-4 text-center text-sm font-semibold text-zinc-900 dark:text-zinc-100 whitespace-nowrap">Cantidad de Casos</th>
                        <th scope="col" class="px-6 py-4 text-center text-sm font-semibold text-zinc-900 dark:text-zinc-100 whitespace-nowrap">Estado</th>
                        <th scope="col" class="px-6 py-4 text-right text-sm font-semibold text-zinc-900 dark:text-zinc-100 whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                    @foreach ($this->processes as $process)
                        <tr wire:key="{{ $process->id }}" class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-600 ">
                            <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-white whitespace-nowrap">
                                {{ $process->name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400">
                                <div class="max-w-2xl truncate" title="{{ $process->description }}">
                                    {{ $process->description }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                                    {{ $process->cases_count }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <form action="{{ route('admin.processes.update', $process->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $process->name }}">
                                    <input type="hidden" name="description" value="{{ $process->description }}">
                                    <input type="hidden" name="active" value="{{ $process->active ? 0 : 1 }}">
                                    <button type="submit" class="hover:opacity-80 transition-opacity font-medium">
                                        @if ($process->active)
                                            <span class="text-lime-600 dark:text-lime-400 text-sm">Activo</span>
                                        @else
                                            <span class="text-red-600 dark:text-red-400 text-sm">Inactivo</span>
                                        @endif
                                    </button>
                                </form>
                            </td>

                            <td class="px-6 py-4 text-right text-sm whitespace-nowrap">
                                <div class="flex justify-end gap-2 items-center">
                                    <button type="button" x-data x-on:click="$dispatch('open-modal', 'edit-process-{{ $process->id }}')" 
                                            class="p-1.5 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors" title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <form action="{{ route('admin.processes.destroy', $process->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('¿Estás seguro de eliminar este proceso?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>