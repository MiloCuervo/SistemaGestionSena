<x-layouts::app>
    <div class="flex flex-col gap-6 mb-8">
        <div class="flex flex-col gap-2">
            <flux:heading size="xl" variant="strong"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">Gestion de
                usuarios
            </flux:heading>
            <flux:separator variant="subtle" />
        </div>

        <div class="grid grid-row-2 gap-x-2 gap-y-4 text-left">
            <p class="text-zinc-500 dark:text-zinc-400">
                Bienvenido <strong
                    class="text-zinc-800 dark:text-zinc-200 font-medium">{{ Auth::user()->name . ' ' . Auth::user()->last_name }}</strong>
            </p>
            <p class="mt-2 max-w-lg text-sm/6 text-gray-400 max-lg:text-center">
                Gestiona y administra los usuarios del sistema. Todos los usuarios comienzan como comisionados y
                requieren permisos adicionales para acceder a funciones administrativas.
            </p>
        </div>
    </div>
    <livewire:user-contact-table />
</x-layouts::app>
