<x-layouts::app :title="__('Crear caso')">
    <div class="mx-auto max-w-3xl px-6 py-8 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-2">
                <flux:button variant="ghost" href="{{ route('user.cases') }}">
                    <flux:icon.arrow-left />
                    Volver
                </flux:button>
            </div>
            <div>
                <flux:heading size="lg">Crear caso</flux:heading>
                <flux:subheading>Registra un nuevo caso en el sistema.</flux:subheading>
            </div>
        </div>

<<<<<<< Updated upstream
        <form action="{{ route('user.cases.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
=======
        {{-- Form --}}
        <form action="{{ route('user.cases.store') }}" method="POST" class="mt-6 space-y-6">
>>>>>>> Stashed changes
            @csrf

            <div class="space-y-4">
                {{-- Tipo de Caso --}}
                <flux:select name="type" label="Tipo de caso" value="{{ old('type') }}">
                    <option value="">Seleccionar tipo</option>
                    <option value="request">Solicitud</option>
                    <option value="denunciation">Denuncia</option>
                    <option value="complaint">Queja</option>
                    <option value="right_of_petition">Derecho de petición</option>
                    <option value="tutelage">Tutela</option>
                </flux:select>
                @error('type')
                    <flux:error>{{ $message }}</flux:error>
                @enderror

                {{-- Radicado Sena --}}
                <flux:input 
                    type="text"
                    name="sena_number" 
                    label="Radicado Sena"
                    placeholder="Opcional, solo para casos relacionados con el Sena"
                    icon="document-text"
                    value="{{ old('sena_number') }}"
                />
                @error('sena_number')
                    <flux:error>{{ $message }}</flux:error>
                @enderror

                {{-- Proceso --}}
                <flux:select name="organization_process_id" label="Proceso" value="{{ old('organization_process_id') }}">
                    <option value="">Seleccionar proceso</option>
                    @foreach ($processes as $process)
                        <option value="{{ $process->id }}">{{ $process->name }}</option>
                    @endforeach
                </flux:select>
                @error('organization_process_id')
                    <flux:error>{{ $message }}</flux:error>
                @enderror

                {{-- Contacto --}}
                <div>
                    <label for="contact_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200 mb-2">
                        Contacto
                    </label>
                    <div class="flex gap-2">
                        <flux:select 
                            name="contact_id" 
                            id="contact_id"
                            class="flex-1"
                            value="{{ old('contact_id', $selectedContactId ?? null) }}"
                        >
                            <option value="">Seleccionar contacto</option>
                            @foreach ($contacts as $contact)
                                <option value="{{ $contact->id }}">
                                    {{ $contact->full_name }}
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:modal.trigger name="create-contact">
                            <flux:button 
                                type="button" 
                                variant="ghost"
                                icon="user-plus"
                                aria-label="Crear contacto"
                            />
                        </flux:modal.trigger>
                    </div>
                    <flux:subheading size="sm" class="mt-2">
                        Si no existe el contacto, crea uno nuevo y luego selecciónalo aquí.
                    </flux:subheading>
                    @error('contact_id')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </div>

<<<<<<< Updated upstream
                <div>
                    <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Descripcion</label>
                    <textarea name="description" id="description" rows="5"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white"></textarea>
                </div>

                <div>
                    <label for="case_evidence" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Evidencia del caso</label>
                    <input id="case_evidence" name="case_evidence" type="file" accept=".pdf,.png,.jpg,.jpeg"
                        class="mt-1 block w-full text-sm text-zinc-700 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-2 file:font-medium file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-300 dark:file:bg-zinc-800 dark:file:text-zinc-100 dark:hover:file:bg-zinc-700" />
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Formatos permitidos: PDF, PNG, JPG. Máximo 5MB.</p>
                </div>
=======
                {{-- Descripción --}}
                <flux:textarea 
                    name="description"
                    label="Descripción"
                    placeholder="Describe los detalles del caso..."
                    rows="5"
                >{{ old('description') }}</flux:textarea>
                @error('description')
                    <flux:error>{{ $message }}</flux:error>
                @enderror
>>>>>>> Stashed changes
            </div>

            {{-- Submit Button --}}
            <div class="flex gap-2">
                <flux:button type="submit" variant="primary" color="lime">
                    Crear Caso
                </flux:button>
            </div>
        </form>
    </div>

    {{-- Modal para crear contacto --}}
    <livewire:create-contact-modal />

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('contact-created', (payload) => {
                const select = document.getElementById('contact_id');
                if (!select) {
                    return;
                }

                const existing = select.querySelector(`option[value="${payload.id}"]`);
                if (!existing) {
                    const option = document.createElement('option');
                    option.value = payload.id;
                    option.textContent = payload.name;
                    select.appendChild(option);
                }

                select.value = payload.id;

                const closeButton = document.querySelector('[data-close-contact-modal]');
                if (closeButton) {
                    closeButton.click();
                } else {
                    document.querySelector('[data-flux-close]')?.click();
                }
            });
        });
    </script>

</x-layouts::app>