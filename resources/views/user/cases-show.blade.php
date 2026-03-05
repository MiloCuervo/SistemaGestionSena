<x-layouts::app :title="__('Ver caso')">
    @php
        $typeLabel = match ($case->type) {
            'request' => 'Solicitud',
            'denunciation' => 'Denuncia',
            'right_of_petition' => 'Derecho de peticion',
            'tutelage' => 'Tutela',
            default => $case->type,
        };

        $statusLabel = match ($case->status) {
            'in_progress' => 'En proceso',
            'attended' => 'Atendido',
            'not_attended' => 'No Atendido',
            default => $case->status,
        };
    @endphp

    <div class="mx-auto max-w-4xl px-6 py-8 lg:px-8">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Detalle del caso</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Información detallada del caso
                    #{{ $case->case_number }}.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('user.cases') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Volver
                </a>
            </div>
        </div>

        <x-case-card :case="$case" :processes="$processes" :contacts="$contacts" readonly />
    </div>
    <div class="mt-3 space-y-3 px-6">
        @forelse ($case->followUps as $followUp)
            <article class="rounded-md border border-zinc-200 p-4 dark:border-zinc-700">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">
                        Seguimiento #{{ $followUp->follow_up_number ?: $followUp->id }}
                    </p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        {{ optional($followUp->created_at)->format('d/m/Y H:i') }}
                    </p>
                </div>
                <p class="mt-2 whitespace-pre-line text-sm text-zinc-800 dark:text-zinc-200">
                    {{ $followUp->description ?: 'Sin descripcion registrada.' }}
                </p>
            </article>
        @empty
            <div
                class="rounded-md border border-dashed border-zinc-300 p-6 text-sm text-zinc-500 dark:border-zinc-700 dark:text-zinc-400">
                Este caso aun no tiene seguimientos registrados.
            </div>
        @endforelse
    </div>
</x-layouts::app>