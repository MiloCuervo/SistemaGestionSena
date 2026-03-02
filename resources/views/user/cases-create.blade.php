<x-layouts::app :title="__('Ver caso')">
    <div class="max-w-2xl px-6 py-8 lg:px-8">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Crear caso</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Registra un nuevo caso.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('user.cases') }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Volver
                </a>
            </div>
        </div>

        <x-case-card :processes="$processes" :contacts="$contacts" />
    </div>
</x-layouts::app>