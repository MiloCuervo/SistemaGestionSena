<?php

use Livewire\Component;
use App\Models\User;
use App\Services\Users\UserService;
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

    #[Computed]
    public function users()
    {
    return app(UserService::class)
            ->query()
            ->when($this->search, fn ($q) =>
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->orderBy($this->sortBy ?? 'id', $this->sortDirection ?? 'desc')
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
        <flux:table.column>Rol</flux:table.column>
        
        <flux:table.column align="end">
            Acciones
        </flux:table.column>


        <flux:table.rows>
            @foreach ($this->users as $user)
                <flux:table.row wire:key="user-{{ $user->id }}">
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar color="lime"> 
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </flux:avatar>
                        {{ $user->name }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $user->email }}
                    </flux:table.cell>
                    <flux:table.cell>
                        {{ $user->configuration->role->name }}
                    </flux:table.cell>
                    <flux:table.cell align="end" class="space-x-2">
                        <flux:button variant="primary" color="lime"
                            type="submit"
                            href="{{ route('admin.users.show', $user) }}"
                        >
                            Visualizar 
                        </flux:button>

                    </flux:table.cell>

                </flux:table.row>
            @endforeach
        </flux:table.rows>

    </flux:table>

</div>