<?php

use Livewire\Component;
use App\Models\Contact;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $sortBy = 'id';
    public $sortDirection = 'desc';

    public function sort($column)
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function cases_count($id)
    {
        $contact = Contact::find($id);
        return $contact->cases()->count();
    }
    #[Computed]
    public function contacts()
    {
        return Contact::withCount('cases')
            ->orderBy('cases_count', $this->sortDirection)
            ->paginate(5);
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
            Cantidad de Casos</flux:table.column>
        <flux:table.column></flux:table.column>
        <flux:table.rows>
            @foreach ($this->contacts as $Contact)
                <flux:table.row :key="$Contact->id">
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar size="xs" src="{{ $Contact->customer_avatar }}" />

                        {{ $Contact->full_name }}
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap">{{ $Contact->identification_number }}</flux:table.cell>

                    <flux:table.cell>
                        <flux:badge size="sm" :color="$Contact->status_color" inset="top bottom">
                            {{ $Contact->email }}</flux:badge>
                    </flux:table.cell>

                    <flux:table.cell variant="strong">{{ $Contact->phone }}</flux:table.cell>

                    <flux:table.cell variant="strong">{{ $Contact->position }}</flux:table.cell>

                    <flux:table.cell variant="strong">{{ $this->cases_count($Contact->id) }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                        </flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>