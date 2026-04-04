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
        <div>
            <flux:heading size="lg">Crear contacto</flux:heading>
            <flux:subheading>Registra un nuevo contacto.</flux:subheading>
        </div>

        <form wire:submit="save" class="space-y-6">
            <div class="space-y-4">
                <div>
                    <label for="modal_full_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Nombre completo</label>
                    <input type="text" id="modal_full_name" wire:model.defer="full_name"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    @error('full_name')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="modal_identification_number" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Numero de identificacion</label>
                    <input type="text" id="modal_identification_number" wire:model.defer="identification_number"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    @error('identification_number')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="modal_email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Correo</label>
                        <input type="email" id="modal_email" wire:model.defer="email"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="modal_phone" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Telefono</label>
                        <input type="text" id="modal_phone" wire:model.defer="phone"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="modal_position" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Cargo</label>
                    <input type="text" id="modal_position" wire:model.defer="position"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    @error('position')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <button type="button" data-close-contact-modal
                        class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Cancelar
                    </button>
                </flux:modal.close>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Guardar contacto
                </button>
            </div>
        </form>
    </div>
</flux:modal>
