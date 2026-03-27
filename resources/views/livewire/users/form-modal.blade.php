<?php

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserConfiguration;
use App\Services\UserService;


new class extends Component {
    public User $user;
    public UserConfiguration $configuration;

    public $name;
    public $second_name;
    public $last_name;
    public $second_last_name;
    public $email;
    public $role_id;

    public function mount(User $user = null)
    {
        $this->user = User::find($user?->id) ?? new User();

        if ($this->user->exists) {
            $this->name = $user->name;
            $this->second_name = $user->second_name;
            $this->last_name = $user->last_name;
            $this->second_last_name = $user->second_last_name;
            $this->email = $user->email;
            $this->role_id = $this->configuration?->role_id;
        }
        
    }

    public function updateProfileInformation()
    {
        $data = $this->validate([
            'email' => ['required|email|unique:users,email,' . $this->user->id,],
            'role_id' => ['required|exists:roles,id'],
        ]);

        try {
            $this->userService->updateUser($this->user, $data);

            session()->flash('success', 'Usuario actualizado correctamente.');

            return redirect()->route('admin.users.show', $this->user->id);

        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el usuario.');
        }
    }
};
?>

<div>
    <p class="text-sm text-gray-200">Solo puedes editar el correo y Rol de los usuarios</p>
    <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6 p-4">
        <flux:input wire:model="email" :label="__('Email')" type="email" autocomplete="email" />
        <div class="grid grid-cols-1 gap-4">
            <flux:select wire:model="role_id" :label="__('Role')">
                <flux:select.option value="1">Administrador</flux:select.option>
                <flux:select.option value="2">Comisionado</flux:select.option>
            </flux:select>
        </div>
        <flux:separator variant="subtle" />
        <div class="flex items-center gap-4">
            <div class="flex items-center justify-center">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
            </div>
        </div>
    </form>
</div>