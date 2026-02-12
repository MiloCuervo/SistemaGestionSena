<x-layouts::app>


    <div class="flex items-start max-md:flex-col">
        <div class="flex items-start max-md:flex-col">
            <div class="me-10 w-full pb-4 md:w-55">
                <flux:navlist aria-label="{{ __('Settings') }}">
                    <flux:navlist.item :href="route('admin.users.show', $user->id)" wire:navigate>{{ __('Profile') }}
                    </flux:navlist.item>
                    <livewire:change-password-modal :user="$user" />
                </flux:navlist>
            </div>
        </div>

        <flux:separator vertical />

        <div class="w-full p-4 mb-4">
            <flux:heading size="xl" variant="strong"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">{{ __('Profile') }}
            </flux:heading>
            <flux:separator variant="subtle" />
            <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2  p-4">
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Name') }}</flux:heading>
                    <flux:text>{{ $user->name }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Second Name') }}</flux:heading>
                    <flux:text>{{ $user->second_name ?? '-' }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Last Name') }}</flux:heading>
                    <flux:text>{{ $user->last_name }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Second Last Name') }}</flux:heading>
                    <flux:text>{{ $user->second_last_name ?? 'N/A' }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Email') }}</flux:heading>
                    <flux:text>{{ $user->email }}</flux:text>
                </div>
                <div>
                    <flux:heading level="3" size="sm" class="mb-1">{{ __('Role') }}</flux:heading>
                    <flux:text>{{ $configuration->role->name }}</flux:text>
                </div>
            </div>
            <livewire:update-user-form :user="$user" />
        </div>


        <flux:separator vertical />

        <div class="w-full p-4">
            <flux:heading size="xl" variant="strong"
                style="font-family: 'DM Serif Display', serif; font-style: italic;">
                Desempeño del usuario  
            </flux:heading>

            <flux:separator variant="subtle" />

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
                <!-- Tarjeta de Sesiones -->
                <div class="bg-zinc-900 rounded-lg border border-zinc-700 p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gray-800 bg-opacity-10 flex items-center justify-center text-blue-500 text-xl">
                            <flux:icon name="clock" />
                        </div>
                        <flux:heading size="sm" variant="strong">Sesiones</flux:heading>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <div class="text-sm text-gray-500">Sesiones este mes</div>
                            <div class="text-2xl font-bold text-white">30</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Última sesión</div>
                            <div class="text-sm text-white">Ayer</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Última actividad</div>
                            <div class="text-sm text-white">Hace 2 dias</div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Casos -->
                <div class="bg-zinc-900 rounded-lg border border-zinc-700 p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gray-800 bg-opacity-10 flex items-center justify-center text-orange-500 text-xl">
                            <flux:icon name="inbox-arrow-down" />
                        </div>
                        <flux:heading size="sm" variant="strong">Casos por Estado</flux:heading>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Pendiente</span>
                            <span class="text-lg font-bold text-yellow-400">20</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">En Proceso</span>
                            <span class="text-lg font-bold text-blue-400">5</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Completado</span>
                            <span class="text-lg font-bold text-green-400">4</span>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta de Estadísticas -->
                <div class="bg-zinc-900 rounded-lg border border-zinc-700 p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gray-800 bg-opacity-10 flex items-center justify-center text-purple-500 text-xl">
                            <flux:icon name="chart-bar" />
                        </div>
                        <flux:heading size="sm" variant="strong">Estadísticas</flux:heading>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <div class="text-sm text-gray-500">Promedio casos/mes</div>
                            <div class="text-2xl font-bold text-white">12</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Promedio sesiones/mes</div>
                            <div class="text-2xl font-bold text-white"> 4</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">% Casos resueltos</div>
                            <div class="text-2xl font-bold text-green-400">50%</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
</x-layouts::app>