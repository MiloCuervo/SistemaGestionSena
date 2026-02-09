<x-layouts::app :title="__('Cases')">
    <div class="mx-auto max-w-7xl px-6 py-8 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Casos</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Listado de casos activos del usuario</p>
            </div>

            <button type="button"
                class="inline-flex items-center justify-center rounded-md bg-white-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200"
                data-open-case-modal>
                Agregar caso
            </button>
        </div>

        <div class="mt-6 rounded-lg border border-zinc-200 bg-white shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="border-b border-zinc-200 px-6 py-4 dark:border-zinc-700">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">Casos activos</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-fixed divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                        <tr>
                            <th scope="col" class="w-[140px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">
                                Tipo
                            </th>
                            <th scope="col" class="w-[240px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">
                                Descripción
                            </th>
                            <th scope="col" class="w-[140px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">
                                Contacto
                            </th>
                            <th scope="col" class="w-[180px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">
                                Proceso
                            </th>
                            <th scope="col" class="w-[140px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">
                                Estado
                            </th>
                            <th scope="col" class="w-[120px] px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 bg-white dark:divide-zinc-700 dark:bg-zinc-900">
                        @php
                            $caseList = collect($cases ?? (isset($case) ? [$case] : []));
                            $caseList = $caseList->filter(function ($item) {
                                return !isset($item->user_id) || $item->user_id === auth()->id();
                            });
                        @endphp

                        @forelse ($caseList as $caseItem)
                            @php
                                $status = $caseItem->status ?? 'unknown';
                            $typeLabel = match ($caseItem->type ?? '') {
                                'request' => 'Solicitud',
                                'denunciation' => 'Denuncia',
                                'right_of_petition' => 'Derecho de petición',
                                'tutelage' => 'Tutela',
                                default => $caseItem->type ?? '—',
                            };
                            $statusLabel = match ($status) {
                                'active', 'activo', 'in_progress' => '<span class="bg-emerald-50 text-emerald-700 px-2 py-1 rounded-full text-xs font-medium">Activo</span>',
                                'waiting', 'en_espera', 'on_hold', 'attended' => '<span class="bg-amber-50 text-amber-700 px-2 py-1 rounded-full text-xs font-medium">En espera</span>',
                                'inactive', 'no_activo', 'closed', 'not_attended' => '<span class="bg-rose-50 text-rose-700 px-2 py-1 rounded-full text-xs font-medium">No activo</span>',
                                default => ucfirst(str_replace('_', ' ', $status)),
                            };
                            $statusClasses = match ($status) {
                                'active', 'activo', 'in_progress' => 'bg-emerald-100 text-emerald-700',
                                'waiting', 'en_espera', 'on_hold', 'attended' => 'bg-amber-100 text-amber-700',
                                'inactive', 'no_activo', 'closed', 'not_attended' => 'bg-rose-100 text-rose-700',
                                default => 'bg-zinc-100 text-zinc-700',
                            };
                            $statusSelectClasses = match ($status) {
                                'active', 'activo', 'in_progress' => 'bg-emerald-50 border-emerald-200',
                                'waiting', 'en_espera', 'on_hold', 'attended' => 'bg-amber-50 border-amber-200',
                                'inactive', 'no_activo', 'closed', 'not_attended' => 'bg-rose-50 border-rose-200',
                                default => 'bg-white border-zinc-300',
                            };
                            $statusTextColor = match ($status) {
                                'active', 'activo', 'in_progress' => '#065f46',
                                'waiting', 'en_espera', 'on_hold', 'attended' => '#92400e',
                                'inactive', 'no_activo', 'closed', 'not_attended' => '#9f1239',
                                default => '#18181b',
                            };
                        @endphp
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-white">
                                    {{ $typeLabel }}
                                </td>
                                <td class="w-[560px] px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    <p class="w-full truncate" title="{{ $caseItem->description ?? '' }}">
                                        {{ $caseItem->description ?? 'Sin descripción' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $caseItem->contact?->full_name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-300">
                                    {{ $caseItem->organizationProcess?->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form method="POST" action="{{ route('user.cases.update-status', $caseItem->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <select name="status"
                                            class="case-status-select w-full min-w-[90px] max-w-[120px] rounded-md border px-3 py-2 text-xs font-semibold shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white {{ $statusSelectClasses }}"
                                            style="color: {{ $statusTextColor }};"
                                            onchange="this.form.submit()">
                                            <option value="in_progress" @selected($caseItem->status === 'in_progress')>Activo</option>
                                            <option value="attended" @selected($caseItem->status === 'attended')>En espera</option>
                                            <option value="not_attended" @selected($caseItem->status === 'not_attended')>Cerrado</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('user.cases.edit', $caseItem->id) }}"
                                            class="inline-flex items-center rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                                            Editar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    Todavía no hay casos activos para mostrar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="caseModal"
        class="fixed inset-0 z-[999] hidden items-center justify-center bg-zinc-900/50 p-4">
        <div class="w-full max-w-sm rounded-lg border border-zinc-200 bg-white p-0 shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
            <form method="POST" action="{{ route('user.cases.store') }}" class="p-4">
                @csrf
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Nuevo caso</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Completa la información del caso.</p>
                    </div>
                    <button type="button"
                        class="rounded-md border border-transparent p-2 text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-600 dark:hover:bg-zinc-800 dark:hover:text-zinc-200"
                        data-close-case-modal>
                        Cerrar
                    </button>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-4">
                    <div>
                        <label for="case_type" class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Tipo de caso</label>
                        <select id="case_type" name="type"
                            class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            required>
                            <option value="request">Solicitud</option>
                            <option value="denunciation">Denuncia</option>
                            <option value="right_of_petition">Derecho de petición</option>
                            <option value="tutelage">Tutela</option>
                        </select>
                    </div>

                    <div>
                        <label for="case_description" class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Descripción</label>
                        <textarea id="case_description" name="description" rows="3"
                            class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                            placeholder="Describe el caso..." required></textarea>
                    </div>

                    <div>
                        <label for="case_status" class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Estado</label>
                        <select id="case_status" name="status"
                            class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            <option value="in_progress">Activo</option>
                            <option value="attended">En espera</option>
                            <option value="not_attended">No activo</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="case_contact" class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Contacto</label>
                            <select id="case_contact" name="contact_id"
                                class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                required>
                                <option value="" selected disabled>Selecciona un contacto</option>
                                @foreach (($contacts ?? collect()) as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->full_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="case_process" class="block text-xs font-medium text-zinc-700 dark:text-zinc-200">Proceso</label>
                            <select id="case_process" name="organization_process_id"
                                class="mt-1 w-full rounded-md border border-zinc-300 px-2.5 py-1.5 text-xs text-zinc-900 shadow-sm focus:border-zinc-900 focus:ring-zinc-900 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                                required>
                                <option value="" selected disabled>Selecciona un proceso</option>
                                @foreach (($processes ?? collect()) as $process)
                                    <option value="{{ $process->id }}">{{ $process->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <button type="button"
                        class="inline-flex justify-center rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800"
                        data-close-case-modal>
                        Cancelar
                    </button>
                    <button type="submit"
                        class="inline-flex justify-center rounded-md border border-zinc-300 px-3 py-1.5 text-xs font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .case-status-select:focus {
            color: #000000;
        }
        .case-status-select option {
            color: #000000;
        }
    </style>
    <script>
        (function () {
            const modal = document.getElementById('caseModal');
            const openBtn = document.querySelector('[data-open-case-modal]');
            const closeBtns = modal ? modal.querySelectorAll('[data-close-case-modal]') : [];

            if (!modal || !openBtn) return;

            const open = () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const close = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            openBtn.addEventListener('click', open);
            closeBtns.forEach(btn => btn.addEventListener('click', close));
            modal.addEventListener('click', (event) => {
                if (event.target === modal) close();
            });
        })();
    </script>
</x-layouts::app>