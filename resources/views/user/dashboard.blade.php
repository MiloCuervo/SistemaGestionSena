<x-layouts::app :title="__('Dashboard')">
    <div class="flex flex-col gap-6 mb-8">
        <div class="flex flex-col gap-2">
            <flux:heading size="xl" variant="strong"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">Dashboard
            </flux:heading>
            <flux:separator variant="subtle" />
        </div>

        <div class="grid grid-row-2 gap-x-2 gap-y-4 text-left">
            <p class="text-zinc-500 dark:text-zinc-400">
                Bienvenido <strong
                    class="text-zinc-800 dark:text-zinc-200 font-medium">{{ Auth::user()->name . ' ' . Auth::user()->last_name }}</strong>
            </p>
                <p class="mt-2 max-w-lg text-sm/6 text-gray-400 max-lg:text-center">
                Bienvenido a tu Sistema de gesition de casos, este es tu <strong>Panel de Control</strong>, aqui
                podras Monitorea todos tus casos y acceder a la informacion detallada de cada uno de ellos.
            </p>

            <p class="mt-2 max-w-lg text-sm/6 text-gray-400 max-lg:text-center">
                <strong>Espacio para graficas</strong>
            </p>
        </div>
    </div>

    <flux:separator variant="subtle" />

    <flux:separator variant="subtle" />
    <div class="flex justify-end px-6 pt-6">
        <a href="{{ route('user.cases.new') }}"
            class="inline-flex items-center justify-center rounded-md bg-zinc-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200">
            Crear caso
        </a>
    </div>
    <div class="max-w-7xl mx-auto px-6 py-8 lg:px-8">
        <livewire:user-cases-table-dashboard />
        </div>

</x-layouts::app>
