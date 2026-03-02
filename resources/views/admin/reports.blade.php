<x-layouts::app>

    {{-- =========================================================
    REPORTS & STATISTICS — SistemaGestionSena
    Vista centrada en Exportaciones y Filtros Globales
    ========================================================= --}}

    {{-- ── Page header ────────────────────────────────────────── --}}
    <div class="flex flex-col gap-2 mb-8 px-4 sm:px-0">
        <flux:heading size="xl" variant="strong" style="font-family: 'DM Serif Display', serif; font-style: italic;">
            Reportes y Estadísticas
        </flux:heading>
        <flux:separator variant="subtle" />
        <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">
            Gestión centralizada de exportaciones y análisis estadístico en tiempo real.
        </p>
    </div>

    {{-- ── PRIMARY CONTROL PANEL (Filters & Exports) ──────────────── --}}
    <div
        class="bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-xl overflow-hidden mb-8 transition-all hover:shadow-2xl mx-4 sm:mx-0">
        <div class="px-8 py-6 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/30">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-zinc-900 dark:text-white">Generador de Reportes</h3>
                    <p class="text-xs text-zinc-500 mt-0.5">Define los parámetros para filtrar la vista y generar
                        documentos oficiales</p>
                </div>
                <div class="flex gap-3">
                    <button onclick="handleExport('excel')"
                        class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM8.5 17l1.77-2.63L8.5 11.75h1.2l1.05 1.92 1.05-1.92h1.2l-1.77 2.62L13.05 17H11.8l-1.05-2-1.05 2H8.5z" />
                        </svg>
                        Excel
                    </button>
                    <button onclick="handleExport('pdf')"
                        class="flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition-all shadow-lg shadow-red-500/20 active:scale-95">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM11 18H9.5v-2H11a1 1 0 0 0 0-2H9.5v-1.5H11a2.5 2.5 0 0 1 0 5z" />
                        </svg>
                        PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Tipo de
                        Reporte</label>
                    <select id="main-report-type"
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 text-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-lime-500/50 appearance-none cursor-pointer">
                        <option value="all_cases">Todos los Casos.</option>
                        <option value="resolved">Casos por tipo.</option>
                        <option value="in_progress">Casos por estado.</option>
                        <option value="pending">Casos por proceso.</option>
                        <option value="users">Casos por comisionado.</option>
                        <option value="commissioners">Lista de Usuarios.</option>
                        <option value="processes">Procesos Organizacionales.</option>
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Fecha
                        Inicio</label>
                    <input type="date" id="main-date-from" value="2025-01-01"
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 text-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-lime-500/50 cursor-pointer">
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Fecha
                        Cierre</label>
                    <input type="date" id="main-date-to" value="2026-02-25"
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 text-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-lime-500/50 cursor-pointer">
                </div>
                <div id="secondary-filter-container" class="flex flex-col gap-2">
                    <label id="filter-secondary-label"
                        class="text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-widest">Filtro
                        Detallado</label>
                    <select id="main-secondary-filter"
                        class="w-full rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 text-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-lime-500/50 appearance-none cursor-pointer">
                        <option value="all">Seleccionar...</option>
                    </select>
                </div>
            </div>

            <div id="export-toast"
                class="hidden mt-6 flex items-center gap-3 px-5 py-4 rounded-2xl bg-lime-50 dark:bg-lime-900/20 border border-lime-200 dark:border-lime-800 text-lime-700 dark:text-lime-400 text-sm font-medium animate-pulse">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span id="export-toast-msg">Actualizando resumen operativo…</span>
            </div>
        </div>
    </div>

    {{-- ── QUICK STATS (KPIs) ────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 px-4 sm:px-0">
        {{-- KPI Cards --}}
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">Casos Filtrados</p>
            <div class="flex items-end gap-2">
                <h4 class="text-3xl font-black text-zinc-900 dark:text-white">142</h4>
                <span class="text-xs text-lime-600 font-bold mb-1.5 whitespace-nowrap">Obj: 200</span>
            </div>
        </div>
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">Eficiencia</p>
            <div class="flex items-end gap-2">
                <h4 class="text-3xl font-black text-zinc-900 dark:text-white">78.4%</h4>
                <span class="text-xs text-emerald-600 font-bold mb-1.5 whitespace-nowrap">↑ 4.2%</span>
            </div>
        </div>
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">T. Promedio</p>
            <div class="flex items-end gap-2">
                <h4 class="text-3xl font-black text-zinc-900 dark:text-white">3.2</h4>
                <span class="text-xs text-zinc-500 font-bold mb-1.5 whitespace-nowrap">días</span>
            </div>
        </div>
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">Activos</p>
            <div class="flex items-end gap-2">
                <h4 class="text-3xl font-black text-zinc-900 dark:text-white">42</h4>
                <span class="text-xs text-violet-600 font-bold mb-1.5 whitespace-nowrap">En rango</span>
            </div>
        </div>
    </div>

    {{-- ── CHARTS & VISUAL DATA ──────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 px-4 sm:px-0">
        {{-- Distribución de Estados --}}
        <div
            class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm transition-all hover:border-lime-200">
            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 mb-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-lime-500"></span>
                Distribución por Estado
            </h3>
            <div id="chart-status-donut" class="min-h-[250px]"></div>
        </div>

        {{-- Carga por Comisionado --}}
        <div
            class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm transition-all hover:border-blue-200">
            <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 mb-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                Top Comisionados Resolutores
            </h3>
            <div id="chart-commissioner" class="min-h-[250px]"></div>
        </div>
    </div>

    {{-- ── SAMPLE DATA TABLE (Vista Previa) ────────────────────── --}}
    <div
        class="bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden mb-12 mx-4 sm:mx-0">
        <div
            class="px-8 py-5 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between bg-zinc-50/30 dark:bg-zinc-800/20">
            <div>
                <h3 class="text-base font-bold text-zinc-900 dark:text-white">Vista Previa de Datos</h3>
                <p class="text-[11px] text-zinc-400">Primeras 5 entradas según los filtros establecidos arriba</p>
            </div>
            <div class="flex items-center gap-2">
                <span
                    class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-lime-100 dark:bg-lime-900/30 text-lime-700 dark:text-lime-400 text-[10px] font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-lime-600 animate-pulse"></span>
                    Sincronizado
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="text-[10px] font-black text-zinc-400 uppercase tracking-widest bg-zinc-50/50 dark:bg-zinc-800/50">
                        <th class="px-8 py-4">Radicado</th>
                        <th class="px-4 py-4">Fecha Reporte</th>
                        <th class="px-4 py-4">Categoría / Proceso</th>
                        <th class="px-4 py-4">Estado</th>
                        <th class="px-8 py-4">Asignado a</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                        <td class="px-8 py-4 font-mono text-xs text-zinc-500 font-bold">#2026-0428</td>
                        <td class="px-4 py-4 text-xs text-zinc-600 dark:text-zinc-400">22 Feb, 2026</td>
                        <td class="px-4 py-4 text-xs font-semibold text-zinc-700 dark:text-zinc-300">Convivencia
                            Académica</td>
                        <td class="px-4 py-4">
                            <span
                                class="px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-[10px] font-bold uppercase">Resuelto</span>
                        </td>
                        <td class="px-8 py-4 text-xs text-zinc-600 dark:text-zinc-400">Dr. Andrés Torres</td>
                    </tr>
                    <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                        <td class="px-8 py-4 font-mono text-xs text-zinc-500 font-bold">#2026-0391</td>
                        <td class="px-4 py-4 text-xs text-zinc-600 dark:text-zinc-400">18 Feb, 2026</td>
                        <td class="px-4 py-4 text-xs font-semibold text-zinc-700 dark:text-zinc-300">Soporte Tecnológico
                        </td>
                        <td class="px-4 py-4">
                            <span
                                class="px-2 py-0.5 rounded-md bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-[10px] font-bold uppercase">En
                                Proceso</span>
                        </td>
                        <td class="px-8 py-4 text-xs text-zinc-600 dark:text-zinc-400">Ing. María López</td>
                    </tr>
                    <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                        <td class="px-8 py-4 font-mono text-xs text-zinc-500 font-bold">#2026-0385</td>
                        <td class="px-4 py-4 text-xs text-zinc-600 dark:text-zinc-400">15 Feb, 2026</td>
                        <td class="px-4 py-4 text-xs font-semibold text-zinc-700 dark:text-zinc-300">Bienestar al
                            Aprendiz</td>
                        <td class="px-4 py-4">
                            <span
                                class="px-2 py-0.5 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 text-[10px] font-bold uppercase">Pendiente</span>
                        </td>
                        <td class="px-8 py-4 text-xs text-zinc-600 dark:text-zinc-400">Lic. Carlos Vega</td>
                    </tr>
                    <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                        <td class="px-8 py-4 font-mono text-xs text-zinc-500 font-bold">#2026-0312</td>
                        <td class="px-4 py-4 text-xs text-zinc-600 dark:text-zinc-400">10 Feb, 2026</td>
                        <td class="px-4 py-4 text-xs font-semibold text-zinc-700 dark:text-zinc-300">Certificación
                            Formativa</td>
                        <td class="px-4 py-4">
                            <span
                                class="px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-[10px] font-bold uppercase">Resuelto</span>
                        </td>
                        <td class="px-8 py-4 text-xs text-zinc-600 dark:text-zinc-400">Dra. Sandra Muñoz</td>
                    </tr>
                    <tr class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                        <td class="px-8 py-4 font-mono text-xs text-zinc-500 font-bold">#2026-0244</td>
                        <td class="px-4 py-4 text-xs text-zinc-600 dark:text-zinc-400">05 Feb, 2026</td>
                        <td class="px-4 py-4 text-xs font-semibold text-zinc-700 dark:text-zinc-300">Infraestructura
                        </td>
                        <td class="px-4 py-4">
                            <span
                                class="px-2 py-0.5 rounded-md bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-[10px] font-bold uppercase">Urgente</span>
                        </td>
                        <td class="px-8 py-4 text-xs text-zinc-600 dark:text-zinc-400">Ing. Luis García</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div
            class="px-8 py-4 bg-zinc-50/50 dark:bg-zinc-800/40 border-t border-zinc-100 dark:border-zinc-800 text-right">
            <button
                class="text-[10px] font-black text-zinc-500 hover:text-lime-600 uppercase tracking-widest transition-colors">
                Ver todos los registros en el reporte maestro →
            </button>
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

                /* ── 1. Estado de Casos — Donut ── */
                const donutEl = document.querySelector('#chart-status-donut');
                if (donutEl && !donutEl._apex) {
                    donutEl._apex = new ApexCharts(donutEl, {
                        series: [92, 34, 16],
                        labels: ['Resueltos', 'En Proceso', 'Pendientes'],
                        chart: {
                            type: 'donut', height: 280,
                            background: 'transparent',
                            foreColor: fg(),
                        },
                        colors: [EMERALD, BLUE, AMBER],
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '75%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total Filtrados',
                                            fontSize: '12px',
                                            fontWeight: 600,
                                            color: fg(),
                                            formatter: () => '142'
                                        }
                                    }
                                }
                            }
                        },
                        legend: { position: 'bottom', labels: { colors: fg() } },
                        stroke: { show: false },
                        dataLabels: { enabled: false },
                        tooltip: { theme: bgTooltip() }
                    });
                    donutEl._apex.render();
                }

                /* ── 2. Carga por Comisionado — Bar ── */
                const commEl = document.querySelector('#chart-commissioner');
                if (commEl && !commEl._apex) {
                    commEl._apex = new ApexCharts(commEl, {
                        series: [{ name: 'Casos Resueltos', data: [42, 38, 35, 27, 24] }],
                        chart: {
                            type: 'bar', height: 280,
                            toolbar: { show: false },
                            background: 'transparent',
                            foreColor: fg(),
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 8,
                                horizontal: true,
                                barHeight: '60%',
                                distributed: true,
                            }
                        },
                        colors: [LIME, EMERALD, BLUE, VIOLET, AMBER],
                        dataLabels: { enabled: true, style: { fontSize: '10px' } },
                        xaxis: {
                            categories: ['Andrés T.', 'María L.', 'Carlos V.', 'Sandra M.', 'Luis G.'],
                            axisBorder: { show: false },
                            labels: { style: { colors: fg() } }
                        },
                        yaxis: { labels: { style: { colors: fg() } } },
                        grid: { borderColor: gridColor(), strokeDashArray: 4 },
                        tooltip: { theme: bgTooltip() }
                    });
                    commEl._apex.render();
                }
            }

            /* ── Export & Filter handler ── */
            window.handleExport = function (format) {
                const type = document.getElementById('main-report-type').value;
                const from = document.getElementById('main-date-from').value;
                const to = document.getElementById('main-date-to').value;

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
                toastMsg.textContent = `Preparando exportación (${format.toUpperCase()}) para "${labels[type]}" entre ${from} y ${to}...`;
                toast.classList.remove('hidden');
                toast.classList.add('flex');

                setTimeout(() => {
                    toastMsg.textContent = `✓ El archivo .${format} ha sido generado exitosamente. Descargando...`;
                    setTimeout(() => {
                        toast.classList.add('hidden');
                        toast.classList.remove('flex');
                    }, 3000);
                }, 2000);
            };

            // Manejo de filtros dinámicos
            const reportTypeSelect = document.getElementById('main-report-type');
            const secondaryLabel = document.getElementById('filter-secondary-label');
            const secondarySelect = document.getElementById('main-secondary-filter');

            const secondaryContainer = document.getElementById('secondary-filter-container');

            const filterData = {
                all_cases: null, // Ocultar
                resolved: { label: 'Tipo de Caso', options: ['Académico', 'Disciplinario', 'Convivencia', 'Administrativo'] },
                in_progress: { label: 'Estado Detallado', options: ['Pendiente', 'Asignado', 'En revisión', 'Aprobado'] },
                pending: { label: 'Proceso Sede', options: ['Bienestar Aprendiz', 'Coordinación', 'Psicología', 'Soporte'] },
                users: { label: 'Comisionado', options: ['Comisionado 1', 'Comisionado 2', 'Comisionado 3', 'Comisionado 4'] },
                commissioners: { label: 'Rango Usuario', options: ['Admin', 'Aprendiz', 'Comisionado'] },
                processes: { label: 'Área Específica', options: ['Sede Norte', 'Sede Sur', 'Centro de Formación'] }
            };

            function updateSecondaryFilter() {
                const type = reportTypeSelect.value;
                const data = filterData[type];

                if (!data) {
                    secondaryContainer.classList.add('hidden');
                    return;
                }

                secondaryContainer.classList.remove('hidden');
                secondaryLabel.textContent = data.label;
                secondarySelect.innerHTML = '';

                data.options.forEach((opt, idx) => {
                    const option = document.createElement('option');
                    option.value = idx === 0 && type !== 'users' ? 'all' : opt.toLowerCase().replace(/ /g, '_');
                    option.textContent = idx === 0 && type !== 'users' ? `Todos (${data.label})` : opt;
                    secondarySelect.appendChild(option);
                });
            }

            if (reportTypeSelect) {
                reportTypeSelect.addEventListener('change', updateSecondaryFilter);
                updateSecondaryFilter(); // Estado inicial
            }

            // Simulación de actualización al cambiar filtros
            ['main-report-type', 'main-date-from', 'main-date-to', 'main-secondary-filter'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('change', () => {
                        const toast = document.getElementById('export-toast');
                        const toastMsg = document.getElementById('export-toast-msg');
                        toastMsg.textContent = `Actualizando datos del resumen...`;
                        toast.classList.remove('hidden');
                        toast.classList.add('flex');
                        setTimeout(() => {
                            toast.classList.add('hidden');
                        }, 1200);
                    });
                }
            });

            document.addEventListener('livewire:navigated', initCharts);
            if (document.readyState === 'complete') {
                initCharts();
            } else {
                window.addEventListener('load', initCharts);
            }
        })();
    </script>

</x-layouts::app>