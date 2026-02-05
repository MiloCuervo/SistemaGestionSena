<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\UserConfiguration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

new class extends Component {
    use WithPagination;

    protected $listeners = ['user-created' => '$refresh'];

    public $sortBy = 'user_id';
    public $sortDirection = 'asc';


    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function users()
    {
        return UserConfiguration::query()
            ->select('user_configurations.*')
            ->with(['user', 'role'])
            ->addSelect([
                'last_activity' => DB::table('sessions')
                    ->select('last_activity')
                    ->whereColumn('user_id', 'user_configurations.user_id')
                    ->latest('last_activity')
                    ->limit(1)
            ])
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(5);
    }

    public function delete($id)
    {
        $userConfiguration = UserConfiguration::find($id);
        $userConfiguration->delete();
        return redirect()->route('admin.users');
    }

    public function showUser($id)
    {
        $userConfiguration = UserConfiguration::find($id);
        return redirect()->route('admin.users.show', $userConfiguration->user->id);
    }

};
?>

<flux:table :paginate="$this->users">
    <flux:table.columns>
        <flux:table.column sortable :sorted="$sortBy === 'user_id'" :direction="$sortDirection"
            wire:click="sort('user_id')">
            {{ __('User') }}
        </flux:table.column>
        <flux:table.column> {{ __('Email') }} </flux:table.column>
        <flux:table.column> {{ __('Role') }} </flux:table.column>
        <flux:table.column> {{ __('Last Session') }} </flux:table.column>
        <flux:table.column> {{ __('Actions') }} </flux:table.column>
    </flux:table.columns>

    <flux:table.rows>
        @foreach ($this->users as $userConfiguration)
            <flux:table.row :key="$userConfiguration->id">
                <flux:table.cell class="flex items-center gap-3">
                    <flux:avatar :name="$userConfiguration->user->name" :initials="$userConfiguration->user->initials()" />
                    <flux:text>{{ $userConfiguration->user->name . ' ' . $userConfiguration->user->second_name ?? 'N/A' }}
                    </flux:text>
                </flux:table.cell>

                <flux:table.cell class="whitespace-nowrap">{{ $userConfiguration->user->email }}</flux:table.cell>

                <flux:table.cell variant="strong">{{ $userConfiguration->role->name ?? 'N/A' }}</flux:table.cell>

                <flux:table.cell>
                    {{ $userConfiguration->last_activity 
                        ? Carbon::createFromTimestamp($userConfiguration->last_activity)->diffForHumans() 
                        : __('Never') }}
                </flux:table.cell>

                <flux:table.cell>
                    <flux:dropdown>
                        <flux:button variant="ghost" size="sm" icon="adjustments-horizontal" inset="top bottom">
                        </flux:button>
                        <flux:menu>
                            <flux:menu.item icon="cog" wire:click="showUser({{ $userConfiguration->user->id }})">
                                {{ __('Edit') }}
                            </flux:menu.item>
                            <flux:menu.item icon="trash" variant="danger" wire:click="delete({{ $userConfiguration->id }})">
                                {{ __('Delete') }}
                            </flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
