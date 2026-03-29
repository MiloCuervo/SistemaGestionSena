<div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-sm space-y-4">
    <div>
        <p class="text-xs text-zinc-400 uppercase tracking-wide">Sesiones este mes</p>
        <p class="text-2xl font-bold text-lime-400 mt-2">{{ $this->sessionsThisMonth }}</p>
    </div>
    <div>
        <p class="text-xs text-zinc-400 uppercase tracking-wide">Última sesión</p>
        <p class="text-lg font-semibold mt-2">{{ $this->lastSessionDate }}</p>
    </div>
    <div>
        <p class="text-xs text-zinc-400 uppercase tracking-wide">Casos Registrados</p>
        <p class="text-2xl font-bold text-lime-400 mt-2">{{ $this->casesCount }}</p>
    </div>
</div>
