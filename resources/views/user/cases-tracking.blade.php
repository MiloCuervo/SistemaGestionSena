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
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Seguimiento</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Consulta el avance y cambia de caso desde el panel lateral.</p>
            </div>
            <a href="{{ route('user.cases') }}"
                class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                Volver
            </a>
        </div>

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
                            </article>
                        @empty
                            <div class="rounded-md border border-dashed border-zinc-300 p-6 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                                Este caso aun no tiene seguimientos registrados.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts::app>