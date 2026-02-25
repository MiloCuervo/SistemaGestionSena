<x-layouts::app>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

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

            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                <!-- Status Distribution Chart  -->
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Distribución de Estados</h3>
                        <span
                            class="px-3 py-1 text-xs font-medium bg-lime-100 text-lime-700 dark:bg-lime-900/30 dark:text-lime-400 rounded-full">
                            Total: {{ $stats['total'] }}
                        </span>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-6">
                        <div id="statsChart" class="flex-1 min-h-[300px] flex items-center justify-center">
                            <div class="animate-pulse text-zinc-400">Cargando gráfico...</div>
                        </div>

                        <div
                            class="w-full lg:w-48 flex flex-col justify-center gap-4 border-t lg:border-t-0 lg:border-s border-zinc-100 dark:border-zinc-800 pt-4 lg:pt-2 lg:ps-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-[#65a30d]"></div>
                                    <span class="text-xs text-zinc-600 dark:text-zinc-400">Resueltos</span>
                                </div>
                                <span
                                    class="text-xs font-bold text-zinc-900 dark:text-white">{{ $stats['attended'] }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-[#3B82F6]"></div>
                                    <span class="text-xs text-zinc-600 dark:text-zinc-400">En Proceso</span>
                                </div>
                                <span
                                    class="text-xs font-bold text-zinc-900 dark:text-white">{{ $stats['in_progress'] }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-[#dc2626]"></div>
                                    <span class="text-xs text-zinc-600 dark:text-zinc-400">No Solucionados</span>
                                </div>
                                <span
                                    class="text-xs font-bold text-zinc-900 dark:text-white">{{ $stats['not_attended'] }}</span>
                            </div>
                        </div>
                    </div>
                </div> <!-- Commissioner Workload Chart (Horizontal Bar) -->
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Casos por Comisionado</h3>
                    </div>

                    <div id="commissionerChart" class="min-h-[300px] flex items-center justify-center">
                        <div class="animate-pulse text-zinc-400">Cargando gráfico...</div>
                    </div>
                </div>
            </div>
            <!-- Cases table -->
            <div>
                <livewire:admin-cases-table />
            </div>

        </div>
    </div>
    <script>
        function initStatsChart() {

            const statusContainer = document.querySelector("#statsChart");
            const commContainer = document.querySelector("#commissionerChart");
            const monthlyContainer = document.querySelector("#chart-cases-monthly");
            if (typeof ApexCharts === 'undefined') return;

            const isDark = document.documentElement.classList.contains('dark');
            const foreColor = isDark ? '#a1a1aa' : '#71717a';

            // 1. RadialBar — Distribución de Estados ($chartData del controlador)
            if (statusContainer) {
                // $chartData = { series: [attended, in_progress, not_attended], labels: [...] }
                const chartData = @json($chartData);

                // Etiquetas legibles en español (el controlador envía keys en inglés)
                const labelMap = {
                    'attended': 'Resueltos',
                    'in_progress': 'En Proceso',
                    'not_attended': 'No Solucionados',
                };
                const labels = chartData.labels.map(l => labelMap[l] || l);

                // Porcentajes sobre el total para la serie radial
                const total = {{ $stats['total'] }} || 1;
                const pctSeries = chartData.series.map(v => parseFloat(((v / total) * 100).toFixed(1)));

                statusContainer.innerHTML = '';
                new ApexCharts(statusContainer, {
                    series: pctSeries,
                    chart: {
                        height: 350,
                        type: 'radialBar',
                        background: 'transparent',
                        foreColor: isDark ? '#b2b2e450' : '#c9c9f767'
                    },
                    plotOptions: {
                        radialBar: {
                            offsetY: 0,
                            startAngle: 0,
                            endAngle: 270,
                            hollow: { margin: 5, size: '30%', background: 'transparent' },
                            dataLabels: {
                                name: { show: false },
                                value: { show: false }
                            },
                            barLabels: {
                                enabled: true,
                                useSeriesColors: true,
                                offsetX: -8,
                                fontSize: '14px',
                                // muestra: "Resueltos: 42" (valor real, no %)
                                formatter: function (seriesName, opts) {
                                    const real = chartData.series[opts.seriesIndex];
                                    return seriesName + ': ' + real;
                                },
                            },
                        }
                    },
                    colors: ['#65a30d', '#3B82F6', '#dc2626'],
                    labels: labels,
                    responsive: [{ breakpoint: 480, options: { legend: { show: false } } }]
                }).render();
            }

            // 2. Commissioner Workload (Horizontal Bar)
            if (commContainer) {
                const commStats = @json($commissionerStats);
                const commOptions = {
                    series: [{
                        name: 'Casos',
                        data: commStats.series
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: { show: false },
                        foreColor: foreColor
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 6,
                            barHeight: '60%',
                            distributed: true,
                        }
                    },
                    colors: ['#3B82F6', '#60A5FA', '#93C5FD', '#BFDBFE'],
                    dataLabels: {
                        enabled: true,
                        textAnchor: 'start',
                        style: { colors: ['#fff'] },
                        formatter: function (val, opt) {
                            return opt.w.globals.labels[opt.dataPointIndex] + ": " + val
                        },
                        offsetX: 0,
                    },
                    xaxis: {
                        categories: commStats.labels,
                        labels: { show: false },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    grid: {
                        show: false,
                        padding: { left: 0, right: 30 }
                    },
                    legend: { show: false },
                    tooltip: { theme: isDark ? 'dark' : 'light' }
                };

                commContainer.innerHTML = '';
                new ApexCharts(commContainer, commOptions).render();
            }


            // 3. Area — Casos por Mes (datos reales desde $monthlySeries del controlador)
            if (monthlyContainer) {
                const monthly = @json($monthlySeries); // { attended: [...12], in_progress: [...12], not_attended: [...12] }

                const monthlyOptions = {
                    series: [
                        { name: 'Resueltos', data: monthly.attended },
                        { name: 'En Proceso', data: monthly.in_progress },
                        { name: 'No Solucionados', data: monthly.not_attended },
                    ],
                    chart: {
                        type: 'area',
                        height: 350,
                        toolbar: { show: false },
                        background: 'transparent',
                        foreColor: foreColor,
                        zoom: { enabled: false }
                    },
                    colors: ['#65a30d', '#3B82F6', '#dc2626'],
                    stroke: { curve: 'smooth', width: 2 },
                    fill: {
                        type: 'gradient',
                        gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.02, stops: [0, 95, 100] }
                    },
                    xaxis: {
                        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        axisBorder: { show: false },
                        axisTicks: { show: false },
                        labels: { style: { colors: foreColor, fontSize: '11px' } }
                    },
                    yaxis: { labels: { style: { colors: foreColor, fontSize: '11px' } } },
                    grid: { borderColor: isDark ? '#3f3f46' : '#e4e4e7', strokeDashArray: 4 },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        labels: { colors: foreColor },
                        fontSize: '12px'
                    },
                    tooltip: { theme: isDark ? 'dark' : 'light' },
                    dataLabels: { enabled: false },
                };

                monthlyContainer.innerHTML = '';
                new ApexCharts(monthlyContainer, monthlyOptions).render();
            }

        }
        document.addEventListener('livewire:navigated', initStatsChart);

        if (document.readyState === 'complete') {
            initStatsChart();
        } else {
            window.addEventListener('load', initStatsChart);
        }
    </script>
</x-layouts::app>