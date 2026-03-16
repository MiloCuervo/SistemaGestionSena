<x-layouts::app :title="__('Crear seguimiento')">
    @php
        $statusLabel = match ($case->status) {
            'in_progress' => 'En proceso',
            'attended' => 'Solucionado',
            'not_attended' => 'No solucionado',
            'closed' => 'Cerrado',
            default => $case->status,
        };
    @endphp

    <div class="mx-auto max-w-3xl px-6 py-8 lg:px-8">
        <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Crear seguimiento</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    Caso {{ $case->case_number ?: 'Sin numero de radicado' }} · Estado: {{ $statusLabel }}
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('user.cases.tracking', $case->id) }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Volver
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div
                class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-950/40 dark:text-red-300">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <form method="POST" action="{{ route('user.cases.follow-ups', $case->id) }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <div>
                    <label for="description"
                        class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Descripcion</label>
                    <textarea id="description" name="description" rows="4" required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-200 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:focus:border-zinc-500 dark:focus:ring-zinc-800">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="follow_up_evidence"
                        class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-200">Archivos adjuntos</label>
                    <input id="follow_up_evidence" name="follow_up_evidence[]" type="file" multiple accept=".pdf,.png,.jpg,.jpeg"
                        class="block w-full text-sm text-zinc-700 file:mr-3 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-2 file:font-medium file:text-zinc-700 hover:file:bg-zinc-200 dark:text-zinc-300 dark:file:bg-zinc-800 dark:file:text-zinc-100 dark:hover:file:bg-zinc-700" />
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Formatos permitidos: PDF, PNG, JPG.</p>
                </div>

                <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('user.cases.tracking', $case->id) }}"
                        class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-3 py-2 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-md bg-zinc-900 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200">
                        Guardar seguimiento
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
