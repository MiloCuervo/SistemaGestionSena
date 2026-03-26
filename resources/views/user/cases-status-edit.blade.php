<x-layouts::app :title="__('Modificar estado')">
    @php
        $typeLabel = match ($case->type) {
            'request' => 'Solicitud',
            'denunciation' => 'Denuncia',
            'complaint' => 'Denuncia',
            'right_of_petition' => 'Derecho de peticion',
            'tutelage' => 'Tutela',
            default => $case->type,
        };
    @endphp

    <div class="mx-auto max-w-4xl px-6 py-8 lg:px-8">
        <div class="flex flex-col gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Modificar estado</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Actualiza el estado del caso #{{ $case->case_number }}.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('user.dashboard') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Volver
                </a>
                <a href="{{ route('user.cases.show', $case->id) }}"
                    class="inline-flex items-center justify-center rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200">
                    Ver caso
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mt-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-950/40 dark:text-red-300">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 lg:col-span-2">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Informacion del caso</h2>
                <dl class="mt-4 space-y-3 text-sm text-zinc-600 dark:text-zinc-300">
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Tipo</dt>
                        <dd>{{ $typeLabel }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Contacto</dt>
                        <dd>{{ $case->contact?->full_name ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Proceso</dt>
                        <dd>{{ $case->organizationProcess?->name ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-col gap-1">
                        <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Descripcion</dt>
                        <dd class="whitespace-pre-line">{{ $case->description ?: 'Sin descripcion registrada.' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Estado</h2>
                <form action="{{ route('user.cases.update-status', $case->id) }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Nuevo estado</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                            <option value="attended" {{ $case->status === 'attended' ? 'selected' : '' }}>Atendido</option>
                            <option value="not_attended" {{ $case->status === 'not_attended' ? 'selected' : '' }}>No atendido</option>
                            <option value="in_progress" {{ $case->status === 'in_progress' ? 'selected' : '' }}>En proceso</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Guardar estado
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
