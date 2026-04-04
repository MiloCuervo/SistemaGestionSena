<?php

use Livewire\Component;
use App\Models\Contact;
use App\Http\Requests\Contacts\CreateContactsRequest;

new class extends Component
{
    public string $full_name = '';
    public string $identification_number = '';
    public string $email = '';
    public string $phone = '';
    public string $position = '';

    public function rules(): array
    {
        return (new CreateContactsRequest())->rules();
    }

    public function save(): void
    {
        $validated = $this->validate();

        $contact = Contact::create($validated);

        $this->dispatch('contact-created', id: $contact->id, name: $contact->full_name);

        $this->reset(['full_name', 'identification_number', 'email', 'phone', 'position']);
        $this->resetValidation();
    }
};
?>
<flux:modal name="create-contact" focusable class="max-w-2xl">
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <flux:heading size="lg">Crear contacto</flux:heading>
            <flux:subheading>Registra un nuevo contacto en el sistema.</flux:subheading>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            <div class="space-y-4">
                {{-- Nombre Completo --}}
                <flux:input 
                    wire:model.defer="full_name"
                    label="Nombre completo"
                    placeholder="Ej: Juan Carlos Pérez"
                    icon="user"
                />
                @error('full_name')
                    <flux:error>{{ $message }}</flux:error>
                @enderror

                {{-- Documento de Identidad --}}
                <flux:input 
                    wire:model.defer="identification_number"
                    label="Número de identificación"
                    placeholder="Ej: 1234567890"
                    icon="identification"
                />
                @error('identification_number')
                    <flux:error>{{ $message }}</flux:error>
                @enderror

                {{-- Email y Teléfono --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <flux:input 
                            type="email"
                            wire:model.defer="email"
                            label="Correo electrónico"
                            placeholder="ejemplo@correo.com"
                            icon="envelope"
                        />
                        @error('email')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </div>
                    <div>
                        <flux:input 
                            type="tel"
                            wire:model.defer="phone"
                            label="Teléfono"
                            placeholder="Ej: +57 300 1234567"
                            icon="phone"
                        />
                        @error('phone')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </div>
                </div>

                {{-- Cargo --}}
                <flux:input 
                    wire:model.defer="position"
                    label="Cargo"
                    placeholder="Ej: Gerente de Proyectos"
                    icon="briefcase"
                />
                @error('position')
                    <flux:error>{{ $message }}</flux:error>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">
                        Cancelar
                    </flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" color="lime">
                    Guardar contacto
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>