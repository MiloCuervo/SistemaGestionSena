<x-layouts::app>

    <div class="flex flex-col gap-6 mb-8">
        <div class="flex flex-col gap-2">
            <div class="text-2xl font-bold text-zinc-800 dark:text-zinc-200"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">Gestion de usuarios
            </div>
            <flux:separator variant="subtle" />
        </div>

        <div class="grid grid-row-2 gap-x-2 gap-y-4 text-left">
            <p class="text-zinc-500 dark:text-zinc-400">
                Bienvenido <strong
                    class="text-zinc-800 dark:text-zinc-200 font-bold">{{ Auth::user()->name . ' ' . Auth::user()->last_name }}</strong>
            </p>
            <p class="mt-2 max-w-lg text-lg/6 text-white max-lg:text-center">
                Gestiona y administra los usuarios del sistema. Todos los usuarios comienzan como comisionados y
                requieren permisos adicionales para acceder a funciones administrativas.
            </p>
        </div>
    </div>
    <flux:separator variant="subtle" />

    <div class="flex gap-4">
        <!-- Cartas de estadísticas a la izquierda -->
        <div class="w-1/3 space-y-4 mt-4">
            <div
                class="bg-gray-200 text-black border border-gray-300 dark:text-white dark:bg-zinc-900 rounded-lg border border-zinc-700 p-5">
                <div class="flex justify-between items-start mb-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-gray-00 bg-opacity-10 flex items-center justify-center text-blue-500 text-xl">
                        <flux:icon name="users" />
                    </div>
                    <span></span>
                </div>
                <div class="text-3xl font-bold text-black dark:text-white mb-1">5</div>
                <div class="text-sm text-gray-500">Total de Usuarios</div>
            </div>

            <div class="bg-zinc-900 rounded-lg border border-zinc-700 p-5">
                <div class="flex justify-between items-start mb-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-gray-400 bg-opacity-10 flex items-center justify-center text-orange-500 text-xl">
                        <flux:icon name="inbox-arrow-down" />
                    </div>
                    <span class="text-xs px-2 py-1 rounded bg-green-500 bg-opacity-10 text-white-400">↑ 10%</span>
                </div>
                <div class="text-3xl font-bold text-white mb-1">30</div>
                <div class="text-sm text-gray-500">Casos en Seguimiento</div>
            </div>

            <div class="bg-zinc-900 rounded-lg border border-zinc-700 p-5">
                <div class="flex justify-between items-start mb-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-gray-500 bg-opacity-10 flex items-center justify-center text-blue-500 text-xl">
                        <flux:icon name="shield-check" />
                    </div>
                    <span class="text-xs px-2 py-1 rounded bg-red-500 bg-opacity-10 text-white-400">↓ 3%</span>
                </div>
                <div class="text-3xl font-bold text-white mb-1">18</div>
                <div class="text-sm text-gray-500">Sesiones del mes</div>
            </div>
        </div>


        <flux:separator vertical />

        <div class="w-2/3">
            <livewire:user-table-component />
        </div>
    </div>
</x-layouts::app>