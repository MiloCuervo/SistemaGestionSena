<?php

use Livewire\Component;
use App\Models\OrganizationProcess;
use App\Models\cases;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $modalMode = 'create'; // 'create' o 'edit'
    public $selectedProcessId = null;

    // Propiedades del formulario
    public $name = '';
    public $description = '';
    public $active = true;

    // Estadísticas
    public function getStatsProperty()
    {
        return [
            'total' => OrganizationProcess::count(),
            'active' => OrganizationProcess::where('active', true)->count(),
            'inactive' => OrganizationProcess::where('active', false)->count(),
            'cases' => cases::count(),
        ];
    }

    public function getProcessesProperty()
    {
        return OrganizationProcess::withCount('cases')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'description', 'active', 'selectedProcessId']);
        $this->modalMode = 'create';
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $process = OrganizationProcess::findOrFail($id);
        $this->selectedProcessId = $id;
        $this->name = $process->name;
        $this->description = $process->description;
        $this->active = $process->active;
        $this->modalMode = 'edit';
        $this->showModal = true;
    }

    public function saveProcess()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'active' => 'required|boolean',
        ]);

        if ($this->modalMode === 'create') {
            OrganizationProcess::create($validated);
            session()->flash('message', 'Proceso creado exitosamente.');
        } else {
            OrganizationProcess::findOrFail($this->selectedProcessId)->update($validated);
            session()->flash('message', 'Proceso actualizado exitosamente.');
        }

        $this->showModal = false;
        $this->reset(['name', 'description', 'active', 'selectedProcessId']);
    }

    public function toggleStatus($id)
    {
        $process = OrganizationProcess::findOrFail($id);
        $process->active = !$process->active;
        $process->save();
        session()->flash('message', 'Estado actualizado.');
    }

    public function deleteProcess($id)
    {
        OrganizationProcess::findOrFail($id)->delete();
        session()->flash('message', 'Proceso eliminado.');
    }
};
?>
<div class="py-8">
    <div class="space-y-8">
        <!-- stats Card -->
        <div
            style="display: flex !important; flex-direction: row !important; gap: 1rem !important; align-items: stretch !important;">
            <div class="flex-1 py-8">
                <flux:card class="flex flex-col gap-2 p-6 border-l-4 border-lime-500 h-full">
                    <flux:text icon="" variant="subtle" size="sm" class="uppercase font-semibold tracking-wider">Activos
                    </flux:text>
                    <div class="flex items-baseline gap-2">
                        <flux:heading size="3xl" class="text-lime-600 dark:text-lime-400">{{ $this->stats['active'] }}
                        </flux:heading>
                    </div>
                </flux:card>
            </div>

            <div class="flex-1 py-8">
                <flux:card class="flex flex-col gap-2 p-6 border-l-4 border-lime-500 h-full">
                    <flux:text variant="subtle" size="sm" class="uppercase font-semibold tracking-wider">Inactivos
                    </flux:text>
                    <div class="flex items-baseline gap-2">
                        <flux:heading size="3xl" class="text-zinc-600 dark:text-lime-400">{{ $this->stats['inactive'] }}
                        </flux:heading>
                    </div>
                </flux:card>
            </div>

            <div class="flex-1 py-8">
                <flux:card class="flex flex-col gap-2 p-6 border-l-4 border-blue-500 h-full">
                    <flux:text variant="subtle" size="sm" class="uppercase font-semibold tracking-wider">Casos Totales
                    </flux:text>
                    <div class="flex items-baseline gap-2">
                        <flux:heading size="3xl" class="text-blue-600 dark:text-blue-400">{{ $this->stats['cases'] }}
                        </flux:heading>
                    </div>
                </flux:card>
            </div>
        </div>


        <div class="flex flex-col gap-2">
            <flux:heading size="xl" variant="strong"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">PROCESOS DEL SISTEMA
            </flux:heading>
            <flux:separator variant="subtle" />
        </div>
        <!-- Header con Búsqueda y Botón Crear -->
        <div class="flex justify-between items-center gap-4 py-8">
            <div class="w-full max-w-md">
                <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Buscar procesos..." />
            </div>
            <flux:button variant="primary" icon="plus" wire:click="openCreateModal">
                Crear Proceso
            </flux:button>
        </div>
        <!-- Tabla de Procesos -->
        <div>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Nombre</flux:table.column>
                    <flux:table.column>Descripción</flux:table.column>
                    <flux:table.column class="text-center">Cantidad de Casos</flux:table.column>
                    <flux:table.column class="text-center">Estado</flux:table.column>
                    <flux:table.column align="end">Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($this->processes as $process)
                        <flux:table.row :key="$process->id">
                            <flux:table.cell class="font-medium text-zinc-900 dark:text-white">
                                {{ $process->name }}
                            </flux:table.cell>

                            <flux:table.cell class="max-w-xs truncate">
                                {{ $process->description }}
                            </flux:table.cell>

                            <flux:table.cell class="text-center">
                                <flux:badge size="sm" color="zinc" inset="top bottom">{{ $process->cases_count }}
                                </flux:badge>
                            </flux:table.cell>

                            <flux:table.cell>
                                @if ($process->active)
                                    <flux:text class="text-lime-600 dark:text-lime-400" size="lg">Activo</flux:text>
                                @else
                                    <flux:text class="text-red-600 dark:text-red-400" size="lg">Inactivo</flux:text>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell align="end">
                                <div class="flex justify-end gap-2">
                                    <flux:button size="sm" variant="ghost" icon="pencil-square" title="Editar"
                                        wire:click="openEditModal({{ $process->id }})" />
                                    <flux:button size="sm" variant="ghost"
                                        :icon="$process->active ? 'no-symbol' : 'check-circle'"
                                        :class="$process->active ? 'text-red-500' : 'text-lime-500'"
                                        wire:click="toggleStatus({{ $process->id }})" title="Activar/Desactivar" />
                                    <flux:button size="sm" variant="ghost" icon="trash" color="red"
                                        wire:confirm="¿Estás seguro de eliminar este proceso?"
                                        wire:click="deleteProcess({{ $process->id }})" title="Eliminar" />
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

        <!-- Modal para Crear/Editor -->
        <flux:modal wire:model="showModal" class="md:w-[600px]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ $modalMode === 'create' ? 'Crear Nuevo Proceso' : 'Editar Proceso' }}
                    </flux:heading>
                    <flux:subheading>Completa los detalles del proceso organizacional.</flux:subheading>
                </div>

                <div class="grid gap-6">
                    <flux:input label="Nombre del Proceso" wire:model="name" placeholder="Ej. Quejas y Reclamos" />
                    <flux:textarea label="Descripción" wire:model="description"
                        placeholder="Describe brevemente el propósito..." />

                    <div class="flex items-center gap-4">
                        <flux:switch wire:model="active" label="Proceso Activo" />
                    </div>
                </div>

                <div class="flex gap-2 justify-end">
                    <flux:button variant="ghost" wire:click="$set('showModal', false)">Cancelar</flux:button>
                    <flux:button variant="primary" wire:click="saveProcess">Guardar</flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>