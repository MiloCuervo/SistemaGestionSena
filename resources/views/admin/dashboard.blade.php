<x-layouts::app>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- � TARJETAS DE RESUMEN --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total de Casos -->
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total de Casos</p>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $data['total'] }}</p>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 p-2 rounded-lg">


                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>

                        </div>
                    </div>
                </div>
                <!-- Casos Resueltos -->
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Resueltos</p>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $data['status']['series'][0] }}</p>
                        </div>
                        <div class="bg-lime-100 dark:bg-lime-900/30 text-lime-600 dark:text-lime-400 p-2 rounded-lg">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>
                <!-- Casos en Proceso -->
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">En Proceso</p>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $data['status']['series'][1] }}</p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>

                        </div>
                    </div>
                </div>
                <!-- Casos No Solucionados -->
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">No Solucionados</p>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $data['status']['series'][2] }}</p>
                        </div>
                        <div class="bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 p-2 rounded-lg">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 📊 GRID DE GRÁFICOS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Distribución de Estados (Donut) --}}
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-white mb-4">Distribución de Estados</h3>
                    <div id="statusChart" class="min-h-[300px] flex items-center justify-center">
                        <div class="animate-pulse text-zinc-400">Cargando gráfico...</div>
                    </div>
                </div>

                {{-- Casos por Comisionado (Barra Horizontal) --}}
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-white mb-4">Casos por Comisionado</h3>
                    <div id="commChart" class="min-h-[300px] flex items-center justify-center">
                        <div class="animate-pulse text-zinc-400">Cargando gráfico...</div>
                    </div>
                </div>

                {{-- Casos por Mes (Barra) --}}
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm md:col-span-2">
                    <h3 class="text-base font-semibold text-zinc-900 dark:text-white mb-4">Casos por Mes</h3>
                    <div id="monthlyChart" class="min-h-[300px] flex items-center justify-center">
                        <div class="animate-pulse text-zinc-400">Cargando gráfico...</div>
                    </div>
                </div>

            </div>

            <!-- Tabla de Casos (Livewire) -->
            <div>
                <livewire:admin-cases-table />
            </div>

        </div>
    </div>

    {{-- Pasamos los datos del controlador a JavaScript --}}
    <script>
        window.dashboardData = @json($data);
    </script>

    <script>
        /**
         * 🧠 Maneja toda la lógica de los gráficos del dashboard.
         * - Evita duplicados al navegar.
         * - Código modular y reutilizable.
         * - Muestra mensajes cuando no hay datos.
         */
        const charts = {};
        const isDark = document.documentElement.classList.contains('dark');
        const foreColor = isDark ? '#a1a1aa' : '#71717a';
        const gridColor = isDark ? '#3f3f46' : '#e4e4e7';

        /**
         * Helper para renderizar gráficos de forma segura, evitando duplicados.
         */
        function renderChart(key, builder) {
            if (charts[key]) {
                charts[key].destroy(); // Destruye la instancia anterior si existe.
            }
            const chartInstance = builder();
            if (chartInstance && typeof chartInstance.render === 'function') {
                chartInstance.render();
                charts[key] = chartInstance; // Almacena la nueva instancia.
            }
        }

        /**
         * Construye el gráfico de Donut para la distribución de estados.
         */
        function buildStatusChart(el, data) {
            if (!el) return null;
            return new ApexCharts(el, {
                chart: { type: 'donut', height: 320, foreColor },
                series: data.series,
                labels: ['Resueltos', 'En Proceso', 'No Solucionados'],
                colors: ['#65a30d', '#3B82F6', '#dc2626'],
                legend: { position: 'bottom', fontSize: '12px', labels: { colors: foreColor } },
                dataLabels: {
                    enabled: true,
                    formatter: (val, opts) => opts.w.config.series[opts.seriesIndex],
                    style: { fontSize: '14px', fontWeight: 'bold' },
                    dropShadow: { enabled: false }
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light',
                    y: { formatter: (val) => `${val} casos` }
                }
            });
        }

        /**
         * Construye el gráfico de barras para los casos por comisionado.
         */
        function buildCommChart(el, data) {
            if (!el) return null;
            if (!data || !data.length) {
                el.innerHTML = '<div class="text-center text-zinc-500 dark:text-zinc-400 py-10">Sin datos de comisionados para mostrar.</div>';
                return { render: () => {}, destroy: () => {} };
            }
            return new ApexCharts(el, {
                chart: { type: 'bar', height: 320, toolbar: { show: false }, foreColor },
                series: [{ name: 'Casos', data: data.map(i => i.value) }],
                xaxis: {
                    categories: data.map(i => i.name),
                    labels: { style: { colors: foreColor, fontSize: '11px' } }
                },
                yaxis: { labels: { style: { colors: foreColor, fontSize: '11px' } } },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        barHeight: '50%',
                        distributed: true,
                    }
                },
                colors: ['#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE'],
                dataLabels: {
                    enabled: true,
                    textAnchor: 'start',
                    style: { colors: ['#fff'], fontSize: '12px' },
                    formatter: (val, opt) => opt.w.globals.labels[opt.dataPointIndex] + ": " + val,
                    offsetX: 0,
                },
                grid: { borderColor: gridColor, strokeDashArray: 4 },
                legend: { show: false },
                tooltip: { theme: isDark ? 'dark' : 'light' }
            });
        }

        /**
         * Valida si hay datos reales en el gráfico mensual.
         */
        function hasMonthlyData(monthly) {
            return [...monthly.attended, ...monthly.in_progress, ...monthly.not_attended].some(v => v > 0);
        }

        /**
         * Construye el gráfico de barras para los casos mensuales.
         */
        function buildMonthlyChart(el, monthly) {
            if (!el) return null;
            if (!hasMonthlyData(monthly)) {
                el.innerHTML = '<div class="text-center text-zinc-500 dark:text-zinc-400 py-10">No hay suficientes datos para mostrar la evolución mensual.</div>';
                return { render: () => {}, destroy: () => {} };
            }
            return new ApexCharts(el, {
                chart: { type: 'bar', height: 320, stacked: true, toolbar: { show: false }, foreColor },
                series: [
                    { name: 'Resueltos', data: monthly.attended },
                    { name: 'En Proceso', data: monthly.in_progress },
                    { name: 'No Solucionados', data: monthly.not_attended },
                ],
                xaxis: {
                    categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    labels: { style: { colors: foreColor, fontSize: '11px' } }
                },
                yaxis: { labels: { style: { colors: foreColor, fontSize: '11px' } } },
                colors: ['#65a30d', '#3B82F6', '#dc2626'],
                dataLabels: { enabled: false },
                grid: { borderColor: gridColor, strokeDashArray: 4 },
                legend: { position: 'top', horizontalAlign: 'right', fontSize: '12px', labels: { colors: foreColor } },
                tooltip: { theme: isDark ? 'dark' : 'light' }
            });
        }

        /**
         * Función principal de inicialización de los gráficos.
         */
        function initDashboardCharts() {
            if (typeof ApexCharts === 'undefined' || !window.dashboardData) {
                return;
            }
            const data = window.dashboardData;

            renderChart('status', () => buildStatusChart(document.querySelector('#statusChart'), data.status));
            renderChart('comm', () => buildCommChart(document.querySelector('#commChart'), data.commissioners));
            renderChart('monthly', () => buildMonthlyChart(document.querySelector('#monthlyChart'), data.monthly));
        }

        // --- INICIALIZACIÓN ---
        // Se asegura de que los gráficos se carguen en la carga inicial y en navegaciones de Livewire.
        document.addEventListener('livewire:navigated', initDashboardCharts);
        if (document.readyState === 'complete') {
            initDashboardCharts();
        } else {
            window.addEventListener('load', initDashboardCharts);
        }
    </script>
</x-layouts::app>
