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

            {{-- KPI 1 — Total de Usuarios --}}
            <div
                class="relative overflow-hidden rounded-2xl border border-blue-500/20 bg-gradient-to-br from-blue-500/[0.07] to-transparent
                        dark:from-blue-500/[0.12] dark:to-zinc-900 backdrop-blur-sm p-5 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-blue-500/10 group">
                {{-- Decorative floating circle --}}
                <div
                    class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-blue-500/10 blur-2xl group-hover:bg-blue-500/20 transition-all duration-500">
                </div>
                <div class="absolute bottom-0 right-3 w-16 h-16 rounded-full bg-blue-400/5 blur-xl"></div>

                <div class="relative flex justify-between items-start mb-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-blue-500/15 flex items-center justify-center text-blue-500 ring-1 ring-blue-500/20 shadow-sm shadow-blue-500/10">
                        <flux:icon name="users" class="w-5 h-5" />
                    </div>
                    <span
                        class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-500 ring-1 ring-emerald-500/20">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                        Activos
                    </span>
                </div>
                <div class="relative">
                    <div class="text-3xl font-extrabold text-zinc-900 dark:text-white tracking-tight mb-0.5">5</div>
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total de Usuarios</div>
                </div>
                {{-- Bottom accent bar --}}
                <div
                    class="absolute bottom-0 left-0 h-[3px] w-full bg-gradient-to-r from-blue-500/60 via-blue-400/30 to-transparent rounded-b-2xl">
                </div>
            </div>

            {{-- KPI 2 — Casos en Seguimiento --}}
            <div
                class="relative overflow-hidden rounded-2xl border border-amber-500/20 bg-gradient-to-br from-amber-500/[0.07] to-transparent
                        dark:from-amber-500/[0.12] dark:to-zinc-900 backdrop-blur-sm p-5 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-amber-500/10 group">
                {{-- Decorative floating circle --}}
                <div
                    class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-amber-500/10 blur-2xl group-hover:bg-amber-500/20 transition-all duration-500">
                </div>
                <div class="absolute bottom-0 right-3 w-16 h-16 rounded-full bg-orange-400/5 blur-xl"></div>

                <div class="relative flex justify-between items-start mb-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-amber-500/15 flex items-center justify-center text-amber-500 ring-1 ring-amber-500/20 shadow-sm shadow-amber-500/10">
                        <flux:icon name="inbox-arrow-down" class="w-5 h-5" />
                    </div>
                    <span
                        class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-500 ring-1 ring-emerald-500/20">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                        ↑ 10%
                    </span>
                </div>
                <div class="relative">
                    <div class="text-3xl font-extrabold text-zinc-900 dark:text-white tracking-tight mb-0.5">30</div>
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Casos en Seguimiento</div>
                </div>
                {{-- Bottom accent bar --}}
                <div
                    class="absolute bottom-0 left-0 h-[3px] w-full bg-gradient-to-r from-amber-500/60 via-amber-400/30 to-transparent rounded-b-2xl">
                </div>
            </div>

            {{-- KPI 3 — Sesiones del mes --}}
            <div
                class="relative overflow-hidden rounded-2xl border border-violet-500/20 bg-gradient-to-br from-violet-500/[0.07] to-transparent
                        dark:from-violet-500/[0.12] dark:to-zinc-900 backdrop-blur-sm p-5 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-violet-500/10 group">
                {{-- Decorative floating circle --}}
                <div
                    class="absolute -top-6 -right-6 w-24 h-24 rounded-full bg-violet-500/10 blur-2xl group-hover:bg-violet-500/20 transition-all duration-500">
                </div>
                <div class="absolute bottom-0 right-3 w-16 h-16 rounded-full bg-purple-400/5 blur-xl"></div>

                <div class="relative flex justify-between items-start mb-4">
                    <div
                        class="w-11 h-11 rounded-xl bg-violet-500/15 flex items-center justify-center text-violet-500 ring-1 ring-violet-500/20 shadow-sm shadow-violet-500/10">
                        <flux:icon name="shield-check" class="w-5 h-5" />
                    </div>
                    <span
                        class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-rose-500/10 text-rose-500 ring-1 ring-rose-500/20">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 4.5l-15 15m0 0h11.25M4.5 19.5V8.25" />
                        </svg>
                        ↓ 3%
                    </span>
                </div>
                <div class="relative">
                    <div class="text-3xl font-extrabold text-zinc-900 dark:text-white tracking-tight mb-0.5">18</div>
                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Sesiones del mes</div>
                </div>
                {{-- Bottom accent bar --}}
                <div
                    class="absolute bottom-0 left-0 h-[3px] w-full bg-gradient-to-r from-violet-500/60 via-violet-400/30 to-transparent rounded-b-2xl">
                </div>
            </div>

        </div>


        <flux:separator vertical />

        <div class="w-2/3">
            <livewire:user-table-component />
        </div>
    </div>
</x-layouts::app>