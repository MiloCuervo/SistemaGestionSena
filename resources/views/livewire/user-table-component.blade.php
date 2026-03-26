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

    <div class="overflow-x-auto bg-white dark:bg-zinc-800 rounded-lg shadow dark:shadow-gray-800/50">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-zinc-800">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:text-gray-700 dark:hover:text-gray-200"
                        wire:click="sort('user_id')">
                        <div class="flex items-center gap-1">
                            {{ __('User') }}
                            @if($sortBy === 'user_id')
                                <span class="ml-1">
                                    @if($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @endif
                        </div>
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        {{ __('Email') }}
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        {{ __('Role') }}
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        {{ __('Last Session') }}
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($users as $userConfiguration)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/80 transition-colors duration-200"
                                wire:key="{{ $userConfiguration->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <!-- Avatar con iniciales -->
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-800 dark:text-indigo-300">
                                                {{ $userConfiguration->user->initials() }}
                                            </span>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $userConfiguration->user->name . ' ' . ($userConfiguration->user->second_name ?? 'N/A') }}
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        {{ $userConfiguration->user->email }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $userConfiguration->role->name ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        {{ $userConfiguration->last_activity
                    ? \Carbon\Carbon::createFromTimestamp($userConfiguration->last_activity)->diffForHumans()
                    : __('Never') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button wire:click="showUser({{ $userConfiguration->user->id }})"
                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 dark:bg-lime-400 dark:hover:bg-lime-900/50 text-gray-700 dark:text-gray-800 rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                        {{ __('Details') }}
                                    </button>
                                </td>
                            </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            {{ __('No users found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>
        <div>