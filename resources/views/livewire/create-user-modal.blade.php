<?php

use Livewire\Component;
use App\Http\Controllers\UserController;


new class extends Component {
    public $name;
    public $second_name;
    public $last_name;
    public $second_last_name;
    public $email;
    public $password;
    public $password_confirmation;



    public function CreateRequest()
    {
        // Recoger todos los datos en un array
        $data = [
            'name' => $this->name,
            'second_name' => $this->second_name,
            'last_name' => $this->last_name,
            'second_last_name' => $this->second_last_name,
            'email' => $this->email,
            'password' => $this->password,
        ];

        // Llamar al método store del UserController (este crea el Request, valida y guarda)
        app(UserController::class)->store($data);

        // Limpiar el formulario
        $this->reset();

        return redirect()->route('admin.users')->with('success', 'User created successfully');
    }


};
?>
<div class="flex justify-end p-4 mb-4">
    <flux:modal.trigger name="create-profile">
        <div class="px-2 py-4">
            <flux:button variant="primary" class="mt-4 rounded-full cursor-pointer hover:bg-lime-700">Crear
                Usuario</flux:button>
        </div>
    </flux:modal.trigger>

    <flux:modal name="create-profile" flyout position="right" size="lg">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg"><strong>Creacíon de usuario</strong></flux:heading>
                <flux:text class="mt-2">Ingrese los datos del usuario.</flux:text>
            </div>

            <flux:input wire:model="name" label="{{ __('Name') }}" placeholder="Tu nombre" />
            <flux:input wire:model="second_name" label="{{ __('Second Name') }}" placeholder="Tu segundo nombre" />
            <flux:input wire:model="last_name" label="{{ __('Last Name') }}" placeholder="Tu apellido" />
            <flux:input wire:model="second_last_name" label="{{ __('Second Last Name') }}" placeholder="Tu segundo apellido" />
            <flux:input wire:model="email" label="{{ __('Email') }}" type="email" placeholder="Tu correo electrónico" />
            <flux:input wire:model="password" type="password" viewable label="{{ __('Password') }}" placeholder="Tu contraseña" />
            <flux:input wire:model="password_confirmation" type="password" viewable label="{{ __('Confirm Password') }}"
                placeholder="Confirma tu contraseña" />
            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary" class="w-full cursor-pointer" wire:click="CreateRequest"
                    wire:close>
                    Guardar</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
