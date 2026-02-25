<x-layouts::app>

    {{-- =========================================================
    REPORTS & STATISTICS — SistemaGestionSena
    Datos quemados para maquetado / UI demo
    ========================================================= --}}

    {{-- ── Page header ────────────────────────────────────────── --}}
    <div class="flex flex-col gap-2 mb-8">
        <flux:heading size="xl" variant="strong" style="font-family: 'DM Serif Display', serif; font-style: italic;">
            Reportes y Estadísticas
        </flux:heading>
        <flux:separator variant="subtle" />
        <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">
            Panel de control general del sistema · datos actualizados al
            <span class="font-medium text-zinc-700 dark:text-zinc-300">25 feb 2026</span>
        </p>
    </div>

    {{-- ── KPI Cards ────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        {{-- Casos totales --}}
        <div
            class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm group hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Casos Totales</span>
                <span
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-lime-100 dark:bg-lime-900/30 text-lime-600 dark:text-lime-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight">248</p>
            <p class="text-xs text-zinc-400 mt-1">
                <span class="text-lime-500 font-semibold">↑ 12%</span> vs mes anterior
            </p>
            <div
                class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-lime-50 dark:bg-lime-900/10 group-hover:scale-110 transition-transform">
            </div>
        </div>

        {{-- Resueltos --}}
        <div
            class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm group hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Resueltos</span>
                <span
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight">162</p>
            <p class="text-xs text-zinc-400 mt-1">
                <span class="text-emerald-500 font-semibold">65.3%</span> tasa de resolución
            </p>
            <div
                class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-emerald-50 dark:bg-emerald-900/10 group-hover:scale-110 transition-transform">
            </div>
        </div>

        {{-- En proceso --}}
        <div
            class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm group hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">En Proceso</span>
                <span
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight">57</p>
            <p class="text-xs text-zinc-400 mt-1">
                <span class="text-blue-500 font-semibold">23%</span> del total activo
            </p>
            <div
                class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-blue-50 dark:bg-blue-900/10 group-hover:scale-110 transition-transform">
            </div>
        </div>

        {{-- Usuarios registrados --}}
        <div
            class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm group hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Usuarios</span>
                <span
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
            </div>
            <p class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight">84</p>
            <p class="text-xs text-zinc-400 mt-1">
                <span class="text-violet-500 font-semibold">↑ 5</span> nuevos este mes
            </p>
            <div
                class="absolute -bottom-4 -right-4 w-20 h-20 rounded-full bg-violet-50 dark:bg-violet-900/10 group-hover:scale-110 transition-transform">
            </div>
        </div>

    </div>

    {{-- ── Charts row 1 ──────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- Casos por mes (Area) --}}
        <div
            class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-1">
                <div>
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Casos por Mes</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Evolución mensual — 2025</p>
                </div>
                <span
                    class="px-3 py-1 text-xs font-medium bg-lime-100 text-lime-700 dark:bg-lime-900/30 dark:text-lime-400 rounded-full">2025</span>
            </div>
            <div id="chart-cases-monthly" class="min-h-[280px]"></div>
        </div>

        {{-- Distribución de estados (Donut) --}}
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <div class="mb-1">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Estado de Casos</h3>
                <p class="text-xs text-zinc-400 mt-0.5">Distribución actual</p>
            </div>
            <div id="chart-status-donut" class="min-h-[280px]"></div>
        </div>

    </div>

    {{-- ── Charts row 2 ──────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Casos por Comisionado (Horizontal Bar) --}}
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-1">
                <div>
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Carga por Comisionado</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Casos asignados actualmente</p>
                </div>
            </div>
            <div id="chart-commissioner" class="min-h-[280px]"></div>
        </div>

        {{-- Casos por Proceso Organizacional (Column) --}}
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-1">
                <div>
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Casos por Proceso</h3>
                    <p class="text-xs text-zinc-400 mt-0.5">Proceso organizacional</p>
                </div>
            </div>
            <div id="chart-process" class="min-h-[280px]"></div>
        </div>

    </div>

    {{-- ── Charts row 3 ──────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Usuarios por Rol (Pie) --}}
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <div class="mb-1">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Usuarios por Rol</h3>
                <p class="text-xs text-zinc-400 mt-0.5">Distribución de roles en el sistema</p>
            </div>
            <div id="chart-users-role" class="min-h-[250px]"></div>
        </div>

        {{-- Tiempo promedio de resolución (RadialBar) --}}
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <div class="mb-1">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Rendimiento General</h3>
                <p class="text-xs text-zinc-400 mt-0.5">Indicadores clave de gestión</p>
            </div>
            <div id="chart-kpi-radial" class="min-h-[250px]"></div>
        </div>

    </div>

    {{-- ── Recent Cases Table ─────────────────────────────────────── --}}
    <div
        class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm mb-8 overflow-hidden">
        <div
            class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 px-6 py-5 border-b border-zinc-100 dark:border-zinc-800">
            <div>
                <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Últimos Casos Registrados</h3>
                <p class="text-xs text-zinc-400 mt-0.5">Mostrando los 8 casos más recientes</p>
            </div>
            {{-- Search filter (decorative, demo) --}}
            <div class="relative w-full sm:w-60">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" placeholder="Buscar caso…"
                    class="w-full pl-9 pr-3 py-2 text-sm rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-lime-500/50">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-100 dark:border-zinc-800">
                        <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Aprendiz</th>
                        <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Proceso</th>
                        <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Comisionado
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @php
                        $rows = [
                            ['CAS-248', 'Laura Ramírez', 'Convivencia', 'Andrés Torres', '20/02/2026', 'Resuelto', 'emerald'],
                            ['CAS-247', 'Felipe Díaz', 'Académico', 'María López', '19/02/2026', 'En Proceso', 'blue'],
                            ['CAS-246', 'Valeria Ospina', 'Psicosocial', 'Carlos Vega', '18/02/2026', 'Pendiente', 'amber'],
                            ['CAS-245', 'Juan Hernández', 'Convivencia', 'Andrés Torres', '17/02/2026', 'Resuelto', 'emerald'],
                            ['CAS-244', 'Sofía Morales', 'Académico', 'María López', '16/02/2026', 'No Solucionado', 'red'],
                            ['CAS-243', 'Diego Castillo', 'Administrativo', 'Luis García', '15/02/2026', 'En Proceso', 'blue'],
                            ['CAS-242', 'Ana Gómez', 'Psicosocial', 'Carlos Vega', '14/02/2026', 'Resuelto', 'emerald'],
                            ['CAS-241', 'Miguel Torres', 'Convivencia', 'Andrés Torres', '13/02/2026', 'Pendiente', 'amber'],
                        ];
                        $badgeMap = [
                            'emerald' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                            'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                            'amber' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                            'red' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                        ];
                    @endphp
                    @foreach($rows as $row)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                            <td class="px-6 py-3.5 font-mono text-xs text-zinc-500">{{ $row[0] }}</td>
                            <td class="px-6 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-7 h-7 rounded-full bg-gradient-to-br from-lime-400 to-emerald-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($row[1], 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $row[1] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 text-zinc-600 dark:text-zinc-400">{{ $row[2] }}</td>
                            <td class="px-6 py-3.5 text-zinc-600 dark:text-zinc-400">{{ $row[3] }}</td>
                            <td class="px-6 py-3.5 text-zinc-500 text-xs">{{ $row[4] }}</td>
                            <td class="px-6 py-3.5">
                                <span
                                    class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badgeMap[$row[5 + 1]] ?? '' }}">
                                    {{ $row[5] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Export Panel ────────────────────────────────────────────── --}}
    <div
        class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-zinc-100 dark:border-zinc-800">
            <h3 class="text-base font-semibold text-zinc-900 dark:text-white">Exportar Reportes</h3>
            <p class="text-xs text-zinc-400 mt-0.5">Selecciona el tipo de reporte y el formato de exportación deseado
            </p>
        </div>

        <div class="p-6">
            {{-- Filters row --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Tipo de Reporte</label>
                    <select id="export-report-type"
                        class="w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-lime-500/50">
                        <option value="all_cases">Todos los Casos</option>
                        <option value="resolved">Casos Resueltos</option>
                        <option value="in_progress">Casos En Proceso</option>
                        <option value="pending">Casos Pendientes</option>
                        <option value="users">Listado de Usuarios</option>
                        <option value="commissioners">Carga de Comisionados</option>
                        <option value="processes">Procesos Organizacionales</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Desde</label>
                    <input type="date" id="export-date-from" value="2025-01-01"
                        class="w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-lime-500/50">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-medium text-zinc-600 dark:text-zinc-400">Hasta</label>
                    <input type="date" id="export-date-to" value="2026-02-25"
                        class="w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 text-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-lime-500/50">
                </div>
            </div>

            {{-- Export cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Excel --}}
                <button onclick="handleExport('excel')"
                    class="group flex items-center gap-4 p-5 rounded-xl border-2 border-dashed border-emerald-200 dark:border-emerald-800 hover:border-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-200 text-left">
                    <div
                        class="flex-shrink-0 w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8.5 17l1.77-2.63L8.5 11.75h1.2l1.05 1.92 1.05-1.92h1.2l-1.77 2.62L13.05 17H11.8l-1.05-2-1.05 2H8.5z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p
                            class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">
                            Exportar a Excel</p>
                        <p class="text-xs text-zinc-400 mt-0.5 truncate">Formato .xlsx — editable y con hojas de cálculo
                        </p>
                    </div>
                    <svg class="w-5 h-5 text-zinc-300 group-hover:text-emerald-500 flex-shrink-0 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </button>

                {{-- PDF --}}
                <button onclick="handleExport('pdf')"
                    class="group flex items-center gap-4 p-5 rounded-xl border-2 border-dashed border-red-200 dark:border-red-800 hover:border-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 text-left">
                    <div
                        class="flex-shrink-0 w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM11 18H9.5v-2H11a1 1 0 0 0 0-2H9.5v-1.5H11a2.5 2.5 0 0 1 0 5z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p
                            class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 group-hover:text-red-700 dark:group-hover:text-red-400 transition-colors">
                            Exportar a PDF</p>
                        <p class="text-xs text-zinc-400 mt-0.5 truncate">Formato .pdf — listo para imprimir o compartir
                        </p>
                    </div>
                    <svg class="w-5 h-5 text-zinc-300 group-hover:text-red-500 flex-shrink-0 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </button>

            </div>

            {{-- Export toast notification (hidden) --}}
            <div id="export-toast"
                class="hidden mt-4 flex items-center gap-3 px-4 py-3 rounded-xl bg-lime-50 dark:bg-lime-900/20 border border-lime-200 dark:border-lime-800 text-lime-700 dark:text-lime-400 text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span id="export-toast-msg">Reporte en preparación…</span>
            </div>
        </div>
    </div>

    {{-- ── ApexCharts Scripts ──────────────────────────────────────── --}}
    <script>
        (function () {
            /* ── Palette ── */
            const LIME = '#65a30d';
            const EMERALD = '#10b981';
            const BLUE = '#3B82F6';
            const AMBER = '#f59e0b';
            const RED = '#ef4444';
            const VIOLET = '#8b5cf6';

            function isDark() {
                return document.documentElement.classList.contains('dark');
            }

            function fg() { return isDark() ? '#a1a1aa' : '#71717a'; }
            function gridColor() { return isDark() ? '#27272a' : '#f4f4f5'; }
            function bgTooltip() { return isDark() ? 'dark' : 'light'; }

            function initCharts() {
                if (typeof ApexCharts === 'undefined') return;

                /* ── 1. Casos por Mes — Area ── */


                /* ── 2. Estado de Casos — Donut ── */
                const donutEl = document.querySelector('#chart-status-donut');
                if (donutEl && !donutEl._apex) {
                    donutEl._apex = new ApexCharts(donutEl, {
                        series: [162, 57, 29],
                        labels: ['Resueltos', 'En Proceso', 'No Solucionados'],
                        chart: {
                            type: 'donut', height: 280,
                            background: 'transparent',
                            foreColor: fg(),
                        },
                        colors: [EMERALD, BLUE, RED],
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '70%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total',
                                            fontSize: '14px',
                                            color: fg(),
                                            formatter: () => '248'
                                        },
                                        value: { color: fg() }
                                    }
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                            labels: { colors: fg() },
                            fontSize: '12px'
                        },
                        tooltip: { theme: bgTooltip() },
                        dataLabels: { enabled: false },
                    });
                    donutEl._apex.render();
                }

                /* ── 3. Charge for Commissioner — Horizontal Bar ── */
                const commEl = document.querySelector('#chart-commissioner');
                if (commEl && !commEl._apex) {
                    commEl._apex = new ApexCharts(commEl, {
                        series: [{ name: 'Casos', data: [78, 63, 55, 42, 10] }],
                        chart: {
                            type: 'bar', height: 280,
                            toolbar: { show: false },
                            foreColor: fg(),
                            background: 'transparent',
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                borderRadius: 6,
                                barHeight: '58%',
                                distributed: true,
                            }
                        },
                        colors: [LIME, EMERALD, BLUE, VIOLET, AMBER],
                        dataLabels: {
                            enabled: true,
                            textAnchor: 'start',
                            style: { colors: ['#fff'], fontSize: '12px' },
                            formatter: (val, opt) => opt.w.globals.labels[opt.dataPointIndex] + ': ' + val,
                            offsetX: 0,
                        },
                        xaxis: {
                            categories: ['Andrés Torres', 'María López', 'Carlos Vega', 'Luis García', 'Sandra Muñoz'],
                            labels: { show: false },
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                        },
                        yaxis: { labels: { show: false } },
                        grid: { show: false, padding: { left: 0, right: 30 } },
                        legend: { show: false },
                        tooltip: { theme: bgTooltip() },
                    });
                    commEl._apex.render();
                }

                /* ── 4. Casos por Proceso — Column ── */
                const procEl = document.querySelector('#chart-process');
                if (procEl && !procEl._apex) {
                    procEl._apex = new ApexCharts(procEl, {
                        series: [{ name: 'Casos', data: [82, 65, 54, 47] }],
                        chart: {
                            type: 'bar', height: 280,
                            toolbar: { show: false },
                            foreColor: fg(),
                            background: 'transparent',
                        },
                        plotOptions: {
                            bar: { borderRadius: 6, columnWidth: '52%', distributed: true }
                        },
                        colors: [LIME, BLUE, AMBER, VIOLET],
                        xaxis: {
                            categories: ['Convivencia', 'Académico', 'Psicosocial', 'Administrativo'],
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: { style: { colors: fg(), fontSize: '11px' } }
                        },
                        yaxis: { labels: { style: { colors: fg(), fontSize: '11px' } } },
                        grid: { borderColor: gridColor(), strokeDashArray: 4 },
                        legend: { show: false },
                        dataLabels: {
                            enabled: true,
                            style: { colors: ['#fff'], fontSize: '12px', fontWeight: '700' }
                        },
                        tooltip: { theme: bgTooltip() },
                    });
                    procEl._apex.render();
                }

                /* ── 5. Usuarios por Rol — Pie ── */
                const roleEl = document.querySelector('#chart-users-role');
                if (roleEl && !roleEl._apex) {
                    roleEl._apex = new ApexCharts(roleEl, {
                        series: [5, 12, 67],
                        labels: ['Admin', 'Comisionado', 'Aprendiz'],
                        chart: {
                            type: 'pie', height: 250,
                            background: 'transparent',
                            foreColor: fg(),
                        },
                        colors: [VIOLET, BLUE, EMERALD],
                        legend: {
                            position: 'bottom',
                            labels: { colors: fg() },
                            fontSize: '12px'
                        },
                        dataLabels: {
                            formatter: (val, opts) => opts.w.globals.labels[opts.seriesIndex] + '\n' + Math.round(val) + '%',
                            style: { fontSize: '11px' }
                        },
                        tooltip: { theme: bgTooltip() },
                    });
                    roleEl._apex.render();
                }

                /* ── 6. Indicadores KPI — RadialBar ── */
                const kpiEl = document.querySelector('#chart-kpi-radial');
                if (kpiEl && !kpiEl._apex) {
                    kpiEl._apex = new ApexCharts(kpiEl, {
                        series: [65.3, 88.1, 72.5],
                        chart: {
                            type: 'radialBar', height: 250,
                            background: 'transparent',
                            foreColor: fg(),
                        },
                        plotOptions: {
                            radialBar: {
                                offsetY: 0,
                                startAngle: -135,
                                endAngle: 135,
                                hollow: { margin: 5, size: '30%', background: 'transparent' },
                                track: { background: isDark() ? '#3f3f46' : '#e4e4e7', strokeWidth: '97%', margin: 5 },
                                dataLabels: {
                                    name: { fontSize: '12px', color: fg(), offsetY: 4 },
                                    value: { fontSize: '18px', fontWeight: '700', color: isDark() ? '#fff' : '#18181b', offsetY: -14 }
                                }
                            }
                        },
                        colors: [EMERALD, LIME, BLUE],
                        labels: ['Resolución', 'Satisfacción', 'Puntualidad'],
                        legend: {
                            show: true, floating: true,
                            position: 'left', offsetY: 8, offsetX: -8,
                            labels: { colors: fg() },
                            fontSize: '12px',
                            markers: { width: 10 },
                            itemMargin: { vertical: 2 }
                        },
                    });
                    kpiEl._apex.render();
                }
            }

            /* ── Export handler ── */
            window.handleExport = function (format) {
                const type = document.getElementById('export-report-type').value;
                const from = document.getElementById('export-date-from').value;
                const to = document.getElementById('export-date-to').value;

                const labels = {
                    all_cases: 'Todos los Casos',
                    resolved: 'Casos Resueltos',
                    in_progress: 'Casos En Proceso',
                    pending: 'Casos Pendientes',
                    users: 'Listado de Usuarios',
                    commissioners: 'Carga de Comisionados',
                    processes: 'Procesos Organizacionales',
                };

                const toast = document.getElementById('export-toast');
                const toastMsg = document.getElementById('export-toast-msg');
                toastMsg.textContent = `Generando "${labels[type]}" en formato .${format.toUpperCase()} (${from} → ${to})…`;
                toast.classList.remove('hidden');
                toast.classList.add('flex');

                // Simulate async delay
                setTimeout(() => {
                    toastMsg.textContent = `✓ Reporte "${labels[type]}" listo para descargar.`;
                    setTimeout(() => {
                        toast.classList.add('hidden');
                        toast.classList.remove('flex');
                    }, 3500);
                }, 1800);

                /* ---------- Conectar con rutas reales ----------
                   window.location.href = `/admin/reports/export?type=${type}&format=${format}&from=${from}&to=${to}`;
                -------------------------------------------------- */
            };

            /* ── Init triggers ── */
            document.addEventListener('livewire:navigated', initCharts);
            if (document.readyState === 'complete') {
                initCharts();
            } else {
                window.addEventListener('load', initCharts);
            }
        })();
    </script>

</x-layouts::app>