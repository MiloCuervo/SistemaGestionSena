<x-layouts::app :title="__('Editar caso')">
    <div class="mx-auto max-w-4xl px-6 py-8 lg:px-8">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Editar caso</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Actualiza la información del caso.</p>
            </div>
            <a href="{{ route('user.cases') }}"
                class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                Volver
            </a>
        </div>

        <div class="mt-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <form method="POST" action="{{ route('user.cases.update', $case->id) }}" class="grid grid-cols-1 gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="case_type" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Tipo de caso</label>
                    <select id="case_type" name="type"
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                        required>
                        <option value="request" @selected($case->type === 'request')>Solicitud</option>
                        <option value="denunciation" @selected($case->type === 'denunciation')>Denuncia</option>
                        <option value="right_of_petition" @selected($case->type === 'right_of_petition')>Derecho de petición</option>
                        <option value="tutelage" @selected($case->type === 'tutelage')>Tutela</option>
                    </select>
                </div>

                <div>
                    <label for="case_description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Descripción</label>
                    <textarea id="case_description" name="description" rows="5"
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                        required>{{ old('description', $case->description) }}</textarea>
                </div>

                <div>
                    <label for="case_status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Estado</label>
                    <select id="case_status" name="status"
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                        <option value="in_progress" @selected($case->status === 'in_progress')>En proceso</option>
                        <option value="attended" @selected($case->status === 'attended')>Solucionado</option>
                        <option value="not_attended" @selected($case->status === 'not_attended')>No solucionado</option>
                        <option value="closed" @selected($case->status === 'closed')>Cerrado</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="case_contact" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Contacto</label>
                        <select id="case_contact" name="contact_id"
                            class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            required>
                            <option value="" disabled>Selecciona un contacto</option>
                            @foreach ($contacts as $contact)
                                <option value="{{ $contact->id }}" @selected($case->contact_id === $contact->id)>
                                    {{ $contact->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="case_process" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Proceso</label>
                        <select id="case_process" name="organization_process_id"
                            class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            required>
                            <option value="" disabled>Selecciona un proceso</option>
                            @foreach ($processes as $process)
                                <option value="{{ $process->id }}" @selected($case->organization_process_id === $process->id)>
                                    {{ $process->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('user.cases') }}"
                        class="inline-flex justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>