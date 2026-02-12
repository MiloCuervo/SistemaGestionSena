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

<div>
    <flux:modal.trigger name="change-password">

            <flux:button variant="ghost" class="mt-4 rounded-full ring-accent-foreground cursor-pointer">Cambiar contraseña</flux:button>
    </flux:modal.trigger>

    <flux:modal name="change-password" class="min-w-88">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg"><strong>Vas a cambiar la contraseña de {{ $this->user->name }}</strong></flux:heading>
            </div>

            @if (!$this->confirmed)
                <div>
                    <p class="font-medium">Advertencia</p>
                    <p class="text-sm text-white">Al cambiar la contraseña se modificará el acceso del usuario.
                        Asegúrate de informar al personal del cambio de su contraseña.</p>
                </div>

                <div class="flex gap-2 pt-2">
                    <flux:button class="hover:bg-gray-500 hover:text-white" variant="ghost" wire:close>Cancelar</flux:button>
                    <flux:button class="hover:bg-red-500" variant="danger" wire:click="confirmWarning">Continuar</flux:button>
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