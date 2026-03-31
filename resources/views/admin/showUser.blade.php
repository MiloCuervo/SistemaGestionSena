<x-layouts::app>
<div class="max-w-screen-2xl mx-auto px-8 py-8 space-y-8">

    {{-- Tarjeta  --}}
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 flex items-center justify-between shadow-sm">
        
        <div class="flex items-center gap-6 flex-1">
            {{-- Avatar --}}
            <div class="w-24 h-24 bg-lime-500 text-zinc-950 rounded-xl flex items-center justify-center text-3xl font-bold ">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>

            {{-- Info Principal --}}
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">
                    {{ $user->name }} {{ $user->last_name }}
                </h1>
                
                <div class="flex items-center gap-3 mt-2">
                    <span class="px-3 py-1 text-xs rounded-lg bg-lime-700 text-lime-100">
                        {{ $configuration->role->name ?? 'Sin rol' }}
                    </span>
                </div>

                <p class="text-slate-300 text-sm mt-3">
                    Comision: {{ $user->created_at->format('Y') ?? 'N/A' }}
                </p>
            </div>
        </div>

        {{-- Porcentaje Perfil --}}
        <div class="text-right">
            <p class="text-xs text-zinc-400 uppercase tracking-wide">Perfil</p>
            <p class="text-4xl font-bold text-lime-400 mt-1">40%</p>
        </div>
    </div>

    {{-- GRID PRINCIPAL --}}
    <div class="grid grid-cols-3 gap-8">

        {{-- COLUMNA IZQUIERDA (Información Personal) --}}
        <div class="col-span-2 space-y-6">

            {{-- Información Personal --}}
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Información Personal</h2>
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">Nombre</p>
                        <p class="text-base font-medium mt-1">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">Segundo Nombre</p>
                        <p class="text-base font-medium mt-1">{{ $user->second_name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">Apellido</p>
                        <p class="text-base font-medium mt-1">{{ $user->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">Segundo Apellido</p>
                        <p class="text-base font-medium mt-1">{{ $user->second_last_name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Información de Contacto --}}
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Información de Contacto (Editable)</h2>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">Email</p>
                        <p class="text-base font-medium mt-1">{{ $user->email }}</p>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">Teléfono</p>
                        <p class="text-base font-medium mt-1">{{ $user->telephone ?? '-' }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- COLUMNA DERECHA (Rol y Estadísticas) --}}
        <div class="col-span-1 space-y-6">

            {{-- Rol y Seguridad --}}
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">Rol y Seguridad</h2>
                <flux:dropdown>
                    <button wire:click="editUser"
                        class="w-full bg-lime-600 hover:bg-lime-700 text-black px-4 py-3 rounded-xl font-medium transition text-sm">
                        Editar usuario 
                    </button>

                    <flux:menu>
                            <form wire:submit.prevent="deleteUser" class="w-full">
                                <input type="email" wire:model="userEmail" placeholder="Email del usuario"
                                    class="w-full px-4 py-2 text-sm rounded-lg bg-zinc-800 text-zinc-200 focus:outline-none focus:ring-2 focus:ring-lime-500">
                                <input type="telephone">
                            </form>                     
                    </flux:menu>
                </flux:dropdown>
            </div>

            {{-- Estadísticas de Sesiones --}}
            <livewire:users.user-statistics :user="$user" />

        </div>

    </div>

    {{-- TABLA DE HISTORIAL --}}
    <livewire:users.user-sessions-table :user="$user" />

</div>
</x-layouts::app>