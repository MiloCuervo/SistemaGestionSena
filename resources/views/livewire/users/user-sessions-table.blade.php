<div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-6 shadow-sm">
    <h2 class="text-lg font-semibold mb-4">Historial de Inicios de Sesión</h2>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-zinc-400 border-b border-zinc-800">
                <tr>
                    <th class="text-left px-6 py-4">Fecha y Hora</th>
                    <th class="text-left px-6 py-4">IP</th>
                    <th class="text-left px-6 py-4">Navegador</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800">
                @forelse($this->logins as $login)
                    <tr class="hover:bg-zinc-800 transition">
                        <td class="px-6 py-4">
                            {{ $login->logged_in_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 font-mono text-xs">
                            {{ $login->ip_address }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $this->getBrowserInfo($login->user_agent) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-zinc-400">
                            No hay sesiones registradas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
