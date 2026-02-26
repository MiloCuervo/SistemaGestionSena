<x-layouts::app :title="__('Seguimiento de caso')">
    @php
        $statusLabel = match ($case->status) {
            'in_progress' => 'En proceso',
            'attended' => 'Solucionado',
            'not_attended' => 'No solucionado',
            'closed' => 'Cerrado',
            default => $case->status,
        };
    @endphp

    <div class="mx-auto max-w-7xl px-6 py-8 lg:px-8">
        <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Seguimientos</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Consulta el avance y cambia de caso desde el panel lateral.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <flux:modal.trigger name="create-follow-up">
                    <flux:button variant="primary" size="sm" icon="plus">
                        Crear seguimiento
                    </flux:button>
                </flux:modal.trigger>

            </div>
        </div>

        @if (session('success'))
            <div
                class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

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

        <flux:modal name="create-follow-up" class="z-50 w-full max-w-2xl">
            <form method="POST" action="{{ route('user.cases.follow-ups', $case->id) }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <div>
                    <flux:heading size="lg">Crear seguimiento</flux:heading>
                    <flux:text class="mt-1">Agrega una descripcion y adjunta archivos si lo necesitas.</flux:text>
                </div>

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
                    <flux:button type="button" variant="ghost" wire:close>Cancelar</flux:button>
                    <flux:button type="submit" variant="primary">Guardar seguimiento</flux:button>
                </div>
            </form>
        </flux:modal>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[280px_1fr]">
            <aside class="rounded-lg border border-zinc-200 bg-white p-4 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Casos</h2>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Selecciona otro caso</p>

                <div class="mt-4 space-y-2">
                    @foreach ($userCases as $caseOption)
                        <a href="{{ route('user.cases.tracking', $caseOption->id) }}"
                            class="block rounded-md border px-3 py-2 text-xs transition {{ $caseOption->id === $case->id ? 'border-zinc-900 bg-zinc-900 text-white dark:border-zinc-100 dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-200 text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800' }}">
                            <p class="font-semibold">{{ $caseOption->case_number ?: 'Sin numero' }}</p>
                            <p class="mt-0.5 opacity-80">Estado: {{ str_replace('_', ' ', $caseOption->status) }}</p>
                        </a>
                    @endforeach
                </div>
            </aside>

            <section class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $case->case_number ?: 'Sin numero de radicado' }}</h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Estado actual: {{ $statusLabel }}</p>
                    </div>
                    <a href="{{ route('user.cases.show', $case->id) }}"
                        class="inline-flex items-center rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Ver caso
                    </a>
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Novedades de seguimiento</h3>

                    <div class="mt-3 space-y-3">
                        @forelse ($case->followUps as $followUp)
                            <article class="rounded-md border border-zinc-200 p-4 dark:border-zinc-700">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                                        Seguimiento #{{ $followUp->follow_up_number ?: $followUp->id }}
                                    </p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ optional($followUp->created_at)->format('d/m/Y H:i') }}</p>
                                </div>
                                <p class="mt-2 whitespace-pre-line text-sm text-zinc-800 dark:text-zinc-200">
                                    {{ $followUp->description ?: 'Sin descripcion registrada.' }}
                                </p>
                                @if (!empty($followUp->follow_up_evidence))
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        @foreach ((array) $followUp->follow_up_evidence as $evidencePath)
                                            <a href="{{ asset('storage/' . $evidencePath) }}" target="_blank"
                                                class="inline-flex items-center rounded-md border border-zinc-300 px-2.5 py-1 text-xs font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-600 dark:text-zinc-200 dark:hover:bg-zinc-800">
                                                Ver archivo
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </article>
                        @empty
                            <div class="rounded-md border border-dashed border-zinc-300 p-6 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-800">
                                Este caso aun no tiene seguimientos registrados.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>


</x-layouts::app>
