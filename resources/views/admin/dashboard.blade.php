<x-layouts::app>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Statistics -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    Estadisticas de los casos
                </h3>

                <livewire:case-stats />
            </div>

            <!-- Cases table -->
            <div>
                <livewire:admin-cases-table />
            </div>

        </div>
    </div>
</x-layouts::app>