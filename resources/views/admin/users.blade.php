<x-layouts::app>
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="bg-zinc-900 text-white p-6 rounded-2xl shadow">
            <h1 class="text-xl font-semibold">Usuarios</h1>
            <p class="text-sm opacity-80">
                Gestiona los usuarios del sistema
            </p>
        </div>
    {{-- card de estadísticas --}}
    @livewire('users.user-stats')
    {{-- tabla de usuarios --}}
    @livewire('users.user-table')
    {{-- Modal --}}
    @livewire('users.form-modal')

    </div>
</x-layouts::app>