@props(['processes', 'contacts', 'case' => null, 'readonly' => false])

<div class="mt-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
    <form action="{{ $readonly ? '#' : route('user.cases.store') }}" method="POST">
        @if(!$readonly)
            @csrf
        @endif

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="type" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Tipo de
                    caso</label>
                <select name="type" id="type" {{ $readonly ? 'disabled' : '' }}
                    class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                    <option value="request" {{ ($case?->type == 'request') ? 'selected' : '' }}>Solicitud</option>
                    <option value="denunciation" {{ ($case?->type == 'denunciation') ? 'selected' : '' }}>Denuncia
                    </option>
                    <option value="right_of_petition" {{ ($case?->type == 'right_of_petition') ? 'selected' : '' }}>
                        Derecho de peticion</option>
                    <option value="tutelage" {{ ($case?->type == 'tutelage') ? 'selected' : '' }}>Tutela</option>
                </select>
            </div>

            <div>
                <label for="organization_process_id"
                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Proceso</label>
                <select name="organization_process_id" id="organization_process_id" {{ $readonly ? 'disabled' : '' }}
                    class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                    @foreach ($processes as $process)
                        <option value="{{ $process->id }}" {{ ($case?->organization_process_id == $process->id) ? 'selected' : '' }}>
                            {{ $process->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="contact_id"
                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Contacto</label>
                <div class="flex gap-2">
                    <select name="contact_id" id="contact_id" {{ $readonly ? 'disabled' : '' }}
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                        <option value="">Seleccionar contacto</option>
                        @foreach ($contacts as $contact)
                            <option value="{{ $contact->id }}" {{ ($case?->contact_id == $contact->id) ? 'selected' : '' }}>
                                {{ $contact->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @if(!$readonly)
                        <a href="#"
                            class="mt-1 inline-flex items-center p-2 border border-zinc-300 rounded-md bg-white hover:bg-zinc-50 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="description"
                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Descripción</label>
                <textarea name="description" id="description" rows="4" {{ $readonly ? 'readonly' : '' }}
                    class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">{{ $case?->description }}</textarea>
            </div>

            @if(!$readonly)
                <div class="sm:col-span-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Crear Caso
                    </button>
                </div>
            @endif
        </div>
    </form>
</div>
