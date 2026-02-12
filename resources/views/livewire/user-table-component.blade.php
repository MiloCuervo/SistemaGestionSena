<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UserConfiguration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Role;

new class extends Component {
    use WithPagination;

    public $user_configuration = [];
    public $user = [];

    public function mount()
    {
        $this->user_configuration = UserConfiguration::all();
        $this->user = User::all();
    }

    protected $listeners = ['user-created' => '$refresh'];

    public $sortBy = 'user_id';
    public $sortDirection = 'asc';
    public $roleFilter = '';
    public $statusFilter = '';
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRoleFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function showUser($id)
    {
        $userConfiguration = UserConfiguration::find($id);
        return redirect()->route('admin.users.show', $userConfiguration->user);
    }

    public function with()
    {
        $query = UserConfiguration::query()
            ->with(['user', 'role'])
            ->addSelect(['user_configurations.*', 'last_activity' => DB::table('sessions')->select('last_activity')->whereColumn('user_id', 'user_configurations.user_id')->latest('last_activity')->limit(1)]);
        // Apply status filter
        if ($this->statusFilter !== '') {
            $query->whereHas('user', function ($q) {
                $q->where('active', $this->statusFilter === '1' ? 1 : 0);
            });
        }
        // Apply role filter
        if ($this->roleFilter !== '') {
            $query->where('role_id', $this->roleFilter);
        }

        // Apply search filter
        if ($this->search !== '') {
            try {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($userQuery) {
                        $userQuery
                            ->where('name', 'like', "%{$this->search}%")
                            ->orWhere('second_name', 'like', "%{$this->search}%")
                            ->orWhere('last_name', 'like', "%{$this->search}%")
                            ->orWhere('second_last_name', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%");
                    })->orWhereHas('role', function ($roleQuery) {
                        $roleQuery->where('name', 'like', "%{$this->search}%");
                    });
                });
            } catch (\Exception $e) {
                // Silent fail if search encounters an error
            }
        }

        // Apply sorting
        if ($this->sortBy) {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        // Return paginated results
        return [
            'users' => $query->paginate(10),
            'roles' => Role::all(),
        ];
    }
};
?>
<div class="flex flex-col gap-4">
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <livewire:create-user-modal />
        <div class="w-full sm:w-1/3">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Busqueda..." />
        </div>
        <flux:dropdown>
            <flux:button icon:trailing="chevron-down">{{ __('Filters') }}</flux:button>

            <flux:menu>
                <flux:menu.submenu heading="{{ __('Roles') }}">
                    <flux:select wire:model.live="roleFilter" placeholder="{{ __('Roles') }}">
                        <flux:select.option value="">{{ __('All roles') }}</flux:select.option>
                        @foreach ($roles as $role)
                            <flux:select.option value="{{ $role->id }}">{{ $role->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:menu.submenu>

                <flux:menu.submenu heading="{{ __('Status') }}">
                    <flux:select wire:model.live="statusFilter" placeholder="{{ __('Status') }}">
                        <flux:select.option value="">{{ __('All statuses') }}</flux:select.option>
                        <flux:select.option value="1">{{ __('Active') }}</flux:select.option>
                        <flux:select.option value="0">{{ __('Inactive') }}</flux:select.option>
                    </flux:select>
                </flux:menu.submenu>
            </flux:menu>
        </flux:dropdown>
    </div>



    <flux:table :paginate="$users">
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
            @foreach ($users as $userConfiguration)
                <flux:table.row :key="$userConfiguration->id">
                    <flux:table.cell class="flex items-center gap-3">
                        <flux:avatar :name="$userConfiguration->user->name"
                            :initials="$userConfiguration->user->initials()" />
                        <flux:text>
                            {{ $userConfiguration->user->name . ' ' . $userConfiguration->user->second_name ?? 'N/A' }}
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

                        <flux:button icon="identification" wire:click="showUser({{ $userConfiguration->user->id }})">
                            {{ __('Details') }}
                        </flux:button>



                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
