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
       $this->user = $user->id ? $user : new User();

        if ($this->user->exists) {
            $this->configuration = UserConfiguration::where("user_id", $this->user->id)->first();
            
            $this->name = $this->user->name;
            $this->second_name = $this->user->second_name;
            $this->last_name = $this->user->last_name;
            $this->second_last_name = $this->user->second_last_name;
            $this->email = $this->user->email;
            $this->role_id = $this->configuration?->role_id;
        }
    }

    public function updateProfileInformation()
    {
        if ($this->user->exists) {
            // Lógica de actualización
            $data = $this->validate([
                'email' => ['required', 'email', 'unique:users,email,' . $this->user->id],
                'role_id' => ['required', 'exists:roles,id'],
            ]);

            // Llama a tu servicio de actualización
            // app(UserService::class)->updateUser($this->user, $data);
            session()->flash('success', 'Usuario actualizado correctamente.');
            
        } else {
            // Lógica de creación
            $data = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'second_name' => ['nullable', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'second_last_name' => ['nullable', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
            ]);
            
            $data['role_id'] = 2; // Fuerza a Comisionado por regla de negocio

            // Llama a tu servicio o controlador de creación
            // app(UserService::class)->createUser($data);
            session()->flash('success', 'Usuario creado correctamente.');
        }

        $this->dispatch('close-modal'); // o recargar la página/redireccionar
    }
};
?>

<div>
    <flux:modal.trigger name="user-modal">
        <flux:button variant="primary" wire:click="$dispatch('open-modal')">+ Nuevo</flux:button>  
    </flux:modal.trigger>

    <flux:modal name="user-modal" flyout position="right" size="lg">
        <p class="text-sm text-gray-400 mb-6">
            {{ $user->exists ? 'Solo puedes editar el correo y Rol de los usuarios' : 'Crear nuevo usuario (Comisionado)' }}
        </p>
        
        <form wire:submit="updateProfileInformation" class="w-full space-y-6 p-4">
            @csrf
            @if(!$user->exists)
                <div class="grid grid-cols-2 gap-4">
                    <flux:input wire:model="name" :label="__('First Name')" required />
                    <flux:input wire:model="second_name" :label="__('Second Name')" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <flux:input wire:model="last_name" :label="__('Last Name')" required />
                    <flux:input wire:model="second_last_name" :label="__('Second Last Name')" />
                </div>
            @endif

            <flux:input wire:model="email" :label="__('Email')" type="email" autocomplete="email" required />
            
            @if($user->exists)
                <div class="grid grid-cols-1 gap-4">
                    <flux:select wire:model="role_id" :label="__('Role')" required>
                        <flux:select.option value="1">Administrador</flux:select.option>
                        <flux:select.option value="2">Comisionado</flux:select.option>
                    </flux:select>
                </div>
            @endif

            <flux:separator variant="subtle" />
            
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center">
                    <flux:button variant="primary" type="submit" class="w-full">
                        {{ $user->exists ? _('Update') : _('Save') }}
                    </flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
