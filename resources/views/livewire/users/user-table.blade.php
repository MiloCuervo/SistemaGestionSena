<?php

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

new class extends Component {

    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sort($column)
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->sortBy = $column;
    }

    public function delete($id)
    {
        User::find($id)?->delete();
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->when($this->search, fn ($q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

};
?>

<div class="space-y-4">

    {{-- Toolbar --}}
    <div class="flex justify-between items-center gap-4">

        <flux:input 
            wire:model.live.debounce.500ms="search"
            placeholder="Buscar usuario..."
            class="w-full md:w-1/3"
        />

        @livewire ("users.form-modal")

    </div>

    {{-- Tabla --}}
    <flux:table :paginate="$this->users">

        <flux:table.column 
            sortable 
            :sorted="$sortBy === 'name'" 
            :direction="$sortDirection"
            wire:click="sort('name')"
        >
            Usuario
        </flux:table.column>

        <flux:table.column>Email</flux:table.column>

        <flux:table.column align="right">
            Acciones
        </flux:table.column>

        <flux:table.rows>
            @foreach ($this->users as $user)
                <flux:table.row :key="$user->id">

                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar size="xs">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </flux:avatar>
                        {{ $user->name }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $user->email }}
                    </flux:table.cell>

                    <flux:table.cell align="right" class="space-x-2">

                        <flux:button 
                            size="sm"
                            wire:click="$dispatch('edit-user', { id: {{ $user->id }} })"
                        >
                            Editar
                        </flux:button>

                        <flux:button 
                            size="sm"
                            variant="danger"
                            wire:click="delete({{ $user->id }})"
                        >
                            Eliminar
                        </flux:button>

                    </flux:table.cell>

                </flux:table.row>
            @endforeach
        </flux:table.rows>

    </flux:table>

</div>