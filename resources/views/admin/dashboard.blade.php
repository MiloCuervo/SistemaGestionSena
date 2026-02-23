<x-layouts::app>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Status Distribution Chart (RadialBar) -->
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
                            class="w-full lg:w-48 flex flex-col justify-center gap-4 border-t lg:border-t-0 lg:border-s border-zinc-100 dark:border-zinc-800 pt-4 lg:pt-0 lg:ps-6">
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
                </div>

                <!-- Commissioner Workload Chart (Horizontal Bar) -->
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
            if (typeof ApexCharts === 'undefined') return;

            const isDark = document.documentElement.classList.contains('dark');
            const foreColor = isDark ? '#a1a1aa' : '#71717a';

            // 1. Status Distribution (RadialBar)
            if (statusContainer) {
                const chartData = @json($chartData);
                const statusOptions = {
                    series: chartData.series,
                    chart: {
                        height: 350,
                        type: 'radialBar',
                        foreColor: isDark ? '#b2b2e450' : '#c9c9f767'
                    },
                    plotOptions: {
                        radialBar: {
                            offsetY: 0,
                            startAngle: 0,
                            endAngle: 270,
                            hollow: {
                                margin: 5,
                                size: '30%',
                                background: 'transparent',
                            },
                            dataLabels: {
                                name: { show: false },
                                value: { show: false }
                            },
                            barLabels: {
                                enabled: true,
                                useSeriesColors: true,
                                offsetX: -8,
                                fontSize: '14px',
                                formatter: function (seriesName, opts) {
                                    return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                                },
                            },
                        }
                    },
                    colors: ['#65a30d', '#3B82F6', '#dc2626'],
                    labels: chartData.labels,
                    responsive: [{
                        breakpoint: 480,
                        options: { legend: { show: false } }
                    }]
                };

                statusContainer.innerHTML = '';
                new ApexCharts(statusContainer, statusOptions).render();
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
        }

        document.addEventListener('livewire:navigated', initStatsChart);

        if (document.readyState === 'complete') {
            initStatsChart();
        } else {
            window.addEventListener('load', initStatsChart);
        }
    </script>
</x-layouts::app>