<?php

use Livewire\Component;
use App\Models\Contact;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $sortBy = 'id';
    public $sortDirection = 'desc';

    // 1. Mantenemos la buena práctica de guardar solo el ID
    public ?int $selectedContactId = null;

    // 2. Nueva variable que controla estrictamente si el modal está abierto o cerrado
    public bool $showContactModal = false;

    public function sort($column)
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    // 3. El método ahora asigna el ID Y abre el modal explícitamente en el backend
    public function openContactModal(int $contactId)
    {
        $this->selectedContactId = $contactId;
        $this->showContactModal = true;
    }
    
    // Método extra para cerrar y limpiar estado (Buena práctica de limpieza de memoria)
    public function closeContactModal()
    {
        $this->showContactModal = false;
        $this->selectedContactId = null;
    }

    #[Computed]
    public function contacts()
    {
        return Contact::withCount('cases')
            ->orderBy('cases_count', $this->sortDirection)
            ->paginate(5);
    }

    #[Computed]
    public function selectedContact()
    {
        // Optimizamos la carga rápida
        return $this->selectedContactId 
            ? Contact::with('cases')->find($this->selectedContactId) 
            : null;
    }
};
?>

<div>
    <flux:table :paginate="$this->contacts">
        <flux:table.column>Contacto</flux:table.column>
        <flux:table.column>Cedula</flux:table.column>
        <flux:table.column>Email</flux:table.column>
        <flux:table.column>Telefono</flux:table.column>
        <flux:table.column>Puesto</flux:table.column>
        <flux:table.column sortable :sorted="$sortBy === 'cases_count'" :direction="$sortDirection"
            wire:click="sort('cases_count')">
            Cantidad de Casos
        </flux:table.column>
        <flux:table.column align="end"></flux:table.column>
        
        <flux:table.rows>
            @foreach ($this->contacts as $Contact)
                <flux:table.row :key="$Contact->id">
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar size="xs" src="{{ $Contact->customer_avatar }}" />
                        {{ $Contact->full_name }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap">
                        {{ $Contact->identification_number }}
                    </flux:table.cell>

                    <flux:table.cell>
                        <flux:badge transition="hover:bg-zinc-50" size="sm" :color="$Contact->status_color" inset="top bottom">
                            {{ $Contact->email }}
                        </flux:badge>
                    </flux:table.cell>

                    <flux:table.cell variant="strong">
                        {{ $Contact->phone }}
                    </flux:table.cell>

                    <flux:table.cell variant="strong">
                        {{ $Contact->position }}
                    </flux:table.cell>

                    <flux:table.cell variant="strong">
                        {{ $Contact->cases_count }}
                    </flux:table.cell>

                    <flux:table.cell align="end">
                        {{-- 
                            Simplemente llamamos al método PHP. Sin triggers adicionales. 
                        --}}
                        <flux:button 
                            variant="ghost" 
                            size="sm" 
                            icon="eye"
                            wire:click="openContactModal({{ $Contact->id }})"
                            aria-label="Ver detalles"
                        />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    {{--  
        AQUÍ ESTÁ LA MAGIA: wire:model="showContactModal" 
        Vincular el estado del modal a Livewire. Si Livewire pasa esta variable a true, Flux/Alpine lo abre. 
        Si el usuario da clic fuera del modal o lo cierra, Alpine notifica a Livewire y pone `showContactModal = false`. 
    --}}
    <flux:modal wire:model="showContactModal" name="contact-details-modal" focusable class="max-w-2xl">
        {{-- Quitamos el if externo por seguridad, dejamos que el modal se renderice pero protejemos el contenido interno --}}
        @if ($this->selectedContact)
            <div class="space-y-6">
                {{-- Header --}}
                <div>
                    <flux:heading size="lg">Detalles del Contacto</flux:heading>
                </div>

                {{-- Información del Contacto --}}
                <div class="bg-zinc-50 dark:bg-zinc-800 rounded-lg p-6 space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Nombre</p>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-white mt-1">
                                {{ $this->selectedContact->full_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Cédula</p>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-white mt-1">
                                {{ $this->selectedContact->identification_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Correo</p>
                            <p class="text-sm text-zinc-900 dark:text-white mt-1 break-all">
                                {{ $this->selectedContact->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Teléfono</p>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-white mt-1">
                                {{ $this->selectedContact->phone ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Cargo</p>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-white mt-1">
                                {{ $this->selectedContact->position ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Casos Relacionados --}}
                <div>
                    <flux:heading size="md">Casos Relacionados</flux:heading>
                    <div class="mt-4 space-y-2">
                        @forelse ($this->selectedContact->cases as $case)
                            <flux:button 
                                variant="ghost" 
                                href="{{ route('admin.cases.show', $case->id) }}"
                                icon:trailing="arrow-up-right" 
                                class="w-full justify-between" 
                                wire:navigate
                            >
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold">{{ $case->case_number }}</span>
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        @if($case->status === 'open') bg-lime-100 text-lime-800 dark:bg-lime-900 dark:text-lime-200
                                        @elseif($case->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($case->status === 'closed') bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                        @endif
                                    ">
                                        {{ ucfirst(str_replace('_', ' ', $case->status ?? 'pending')) }}
                                    </span>
                                </div>
                                <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $case->created_at->format('d/m/Y') }}
                                </span>
                            </flux:button>
                        @empty
                            <div class="p-4 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                    Este contacto no tiene casos registrados aún.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-2">
                    {{-- Cerramos usando el método PHP para asegurarnos de que limpiamos la variable ID --}}
                    <flux:button variant="ghost" wire:click="closeContactModal">
                        Cerrar
                    </flux:button>
                </div>
            </div>
        @else
            <div class="flex justify-center items-center py-12">
                <svg class="animate-spin h-8 w-8 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        @endif
    </flux:modal>
    
</div>


