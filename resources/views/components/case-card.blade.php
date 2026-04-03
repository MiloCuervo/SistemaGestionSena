@props([
    'case',
    'processes' => collect(),
    'contacts' => collect(),
    'readonly' => false,
])

@php
    $typeLabel = match ($case->type) {
        'request' => 'Solicitud',
        'denunciation' => 'Denuncia',
        'complaint' => 'Denuncia',
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

<div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
    <div class="flex flex-wrap items-center justify-between gap-2">
        <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Informacion del caso</h2>
        <span class="rounded-full border border-zinc-200 px-2.5 py-1 text-xs font-semibold text-zinc-600 dark:border-zinc-700 dark:text-zinc-300">
            {{ $statusLabel }}
        </span>
    </div>

    <dl class="mt-4 space-y-3 text-sm text-zinc-600 dark:text-zinc-300">
        <div class="flex flex-col gap-1">
            <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Numero de radicado</dt>
            <dd>{{ $case->case_number ?: 'Sin numero de radicado' }}</dd>
        </div>

        <div class="flex flex-col gap-1">
            <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Numero de radicado Sena</dt>
            <dd>{{ $case->sena_number ?: 'Sin numero de radicado Sena' }}</dd>
        </div>

        <div class="flex flex-col gap-1">
            <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Tipo</dt>
            <dd>{{ $typeLabel }}</dd>
        </div>
        <div class="flex flex-col gap-1">
            <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Contacto</dt>
            <dd>{{ $case->contact?->full_name ?? '-' }}</dd>
        </div>
        <div class="flex flex-col gap-1">
            <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Proceso</dt>
            <dd>{{ $case->organizationProcess?->name ?? '-' }}</dd>
        </div>
        <div class="flex flex-col gap-1">
            <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Descripcion</dt>
            <dd class="whitespace-pre-line">{{ $case->description ?: 'Sin descripcion registrada.' }}</dd>
        </div>
        <div class="flex flex-col gap-1">
            <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Evidencia</dt>
            <dd>{{ $case->case_evidence ?: 'Sin evidencia registrada.' }}</dd>
        </div>
        <div class="flex flex-col gap-1">
            <dt class="text-xs uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Fecha de cierre</dt>
            <dd>{{ optional($case->closed_date)->format('d/m/Y') ?: '-' }}</dd>
        </div>
    </dl>
</div>
