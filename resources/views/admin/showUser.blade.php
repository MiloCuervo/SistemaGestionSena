<x-layouts::app>
<div class="max-w-screen-2xl mx-auto px-2 space-y-4">

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
            <p class="text-xs text-zinc-400 uppercase tracking-wide">{{ __('User') }}</p>
            <p class="text-4xl font-bold text-lime-400 mt-1">{{ $user->id}}</p>
        </div>
    </div>

    {{-- GRID PRINCIPAL --}}
    <div class="grid grid-cols-3 gap-8">

        {{-- COLUMNA IZQUIERDA (Información Personal) --}}
        <div class="col-span-2 space-y-6">

            {{-- Información Personal --}}
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold mb-4">{{ __('Personal Information') }}</h2>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">{{ __('Name') }}</p>
                        <p class="text-base font-medium mt-1">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">{{ __('Second Name') }}</p>
                        <p class="text-base font-medium mt-1">{{ $user->second_name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">{{ __('Last Name') }}</p>
                        <p class="text-base font-medium mt-1">{{ $user->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-400 uppercase tracking-wide">{{ __('Second Last Name') }}</p>
                        <p class="text-base font-medium mt-1">{{ $user->second_last_name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Información de Contacto (Editable) --}}
            <div x-data="{ editing: false, email: '{{ $user->email }}', telephone: '{{ $user->telephone ?? '' }}' }" class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-sm">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">{{ __('Contact Information') }}</h2>
                        <div>
                            <template x-if="!editing">
                                <button type="button" @click="editing = true" class="text-sm text-lime-400 hover:text-lime-300">
                                    Editar
                                </button>
                            </template>
                            <template x-if="editing">
                                <div class="flex items-center gap-2">
                                    <button type="submit" class="text-sm text-lime-400 hover:text-lime-300">
                                        Guardar
                                    </button>
                                    <button type="button" @click="editing = false; email = '{{ $user->email }}'; telephone = '{{ $user->telephone ?? '' }}'" class="text-sm text-zinc-400 hover:text-zinc-300">
                                        Cancelar
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- EMAIL --}}
                        <div>
                            <p class="text-xs text-zinc-400 uppercase tracking-wide">Email</p>
                            <div class="mt-1">
                                <p x-show="!editing" class="text-base font-medium">{{ $user->email }}</p>
                                <template x-if="editing">
                                    <input type="email" name="email" x-model="email" class="w-full px-4 py-2 text-sm rounded-lg bg-zinc-800 text-zinc-200 focus:outline-none focus:ring-2 focus:ring-lime-500">
                                </template>
                            </div>
                        </div>
                        {{-- TELEPHONE --}}
                        <div>
                            <p class="text-xs text-zinc-400 uppercase tracking-wide">Teléfono</p>
                            <div class="mt-1">
                                <p x-show="!editing" class="text-base font-medium">{{ $user->telephone ?? '-' }}</p>
                                <template x-if="editing">
                                    <input type="text" name="telephone" x-model="telephone" class="w-full px-4 py-2 text-sm rounded-lg bg-zinc-800 text-zinc-200 focus:outline-none focus:ring-2 focus:ring-lime-500">
                                </template>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        {{-- COLUMNA DERECHA (Estadísticas) --}}
        <div class="space-y-6">

            {{-- Estadísticas de Sesiones --}}
            <livewire:users.user-statistics :user="$user" />

        </div>
        
    </div>
    
    {{-- TABLA DE HISTORIAL --}}
    <livewire:users.user-sessions-table :user="$user" />
</div>

</x-layouts::app>