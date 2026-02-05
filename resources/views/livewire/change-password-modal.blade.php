<?php

use Livewire\Component;
use App\Models\User;

new class extends Component {
    public User $user;
    public $password;
    public $password_confirmation;
    public $confirmed = false;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function confirmWarning()
    {
        $this->confirmed = true;
    }

    public function changePassword()
    {
        $data = $this->validate([
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|same:password',
        ]);

        $this->user->password = bcrypt($data['password']);
        $this->user->save();

        session()->flash('success', 'Contraseña actualizada correctamente.');
        return redirect()->route('admin.users.show', $this->user->id);
    }
};
?>

<div class="mt-6">
    <flux:modal.trigger name="change-password">
        <div class="px-2 py-4">
            <flux:button variant="ghost" class="mt-4 rounded-full cursor-pointer">Cambiar contraseña</flux:button>
        </div>
    </flux:modal.trigger>

    <flux:modal name="change-password" class="min-w-[22rem]">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg"><strong>Cambiar contraseña</strong></flux:heading>
            </div>

            @if (!$this->confirmed)
                <div>
                    <p class="font-medium">Advertencia</p>
                    <p class="text-sm text-yellow-700">Al cambiar la contraseña se modificará el acceso del usuario.
                        Asegúrate de informar al personal del cambio de su contraseña.</p>
                </div>

                <div class="flex gap-2 pt-2">
                    <flux:button variant="ghost" wire:close>Cancelar</flux:button>
                    <flux:button variant="danger" wire:click="confirmWarning">Continuar</flux:button>
                </div>
            @else
                <flux:input wire:model="password" type="password" viewable label="Nueva contraseña"
                    placeholder="Nueva contraseña" />
                <flux:input wire:model="password_confirmation" type="password" viewable label="Confirmar contraseña"
                    placeholder="Confirmar contraseña" />

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary" class="w-full" wire:click="changePassword" wire:close>
                        Guardar</flux:button>
                </div>
            @endif
        </div>
    </flux:modal>
</div>