<x-layouts::app :title="__('Crear caso')">
    <div class="mx-auto max-w-3xl px-6 py-8 lg:px-8">
        <div class="flex flex-col gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Crear caso</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Registra un nuevo caso.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('user.cases') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Volver
                </a>
            </div>
        </div>

        <form action="{{ route('user.cases.store') }}" method="POST" class="mt-6 space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="type" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Tipo de caso</label>
                    <select name="type" id="type"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                        <option value="request">Solicitud</option>
                        <option value="denunciation">Denuncia</option>
                        <option value="right_of_petition">Derecho de peticion</option>
                        <option value="tutelage">Tutela</option>
                    </select>
                </div>

                <div>
                    <label for="organization_process_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Proceso</label>
                    <select name="organization_process_id" id="organization_process_id"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                        @foreach ($processes as $process)
                            <option value="{{ $process->id }}">{{ $process->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="contact_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Contacto</label>
                    <div class="flex gap-2">
                        <select name="contact_id" id="contact_id"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                            <option value="">Seleccionar contacto</option>
                            @foreach ($contacts as $contact)
                                <option value="{{ $contact->id }}" {{ (old('contact_id', $selectedContactId ?? null) == $contact->id) ? 'selected' : '' }}>
                                    {{ $contact->full_name }}
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('user.contacts.create', ['return_to' => route('user.cases.new')]) }}"
                            class="mt-1 inline-flex items-center rounded-md border border-zinc-300 bg-white p-2 hover:bg-zinc-50 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </a>
                    </div>
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                        Si no existe el contacto, crea uno nuevo y luego selecciónalo aquí.
                    </p>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Descripcion</label>
                    <textarea name="description" id="description" rows="5"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white"></textarea>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Crear Caso
                </button>
            </div>
        </form>
    </div>

</x-layouts::app>
