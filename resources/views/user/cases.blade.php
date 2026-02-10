<x-layouts::app :title="__('Cases')">
<div class="flex flex-col gap-6 mb-8">
        <div class="flex flex-col gap-2">
            <flux:heading size="xl" variant="strong"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">Panel de Control
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
                podras Monitorea todos los casos y acceder a la informacion detallada de cada uno de ellos.
            </p>
        </div>
    </div>
    <flux:separator variant="subtle" />
    <div class="max-w-7xl mx-auto px-6 py-8 lg:px-8">
        <livewire:user-cases-table-dashboard />
    </div>
</x-layouts::app>
