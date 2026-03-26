<x-layouts::app :title="__('Crear contacto')">
    <div class="mx-auto max-w-3xl px-6 py-8 lg:px-8">
        <div class="flex flex-col gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Crear contacto</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Registra un nuevo contacto.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ $returnTo }}"
                    class="inline-flex items-center justify-center rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    Volver
                </a>
            </div>
        </div>

        <form action="{{ route('user.contacts.store') }}" method="POST" class="mt-6 space-y-6">
            @csrf
            <input type="hidden" name="return_to" value="{{ $returnTo }}">

            @if ($errors->any())
                <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-800 dark:bg-red-950/40 dark:text-red-300">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="full_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Nombre completo</label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>

                <div>
                    <label for="identification_number" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Numero de identificacion</label>
                    <input type="text" name="identification_number" id="identification_number" value="{{ old('identification_number') }}"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Correo</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Telefono</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                    </div>
                </div>

                <div>
                    <label for="position" class="block text-sm font-medium text-zinc-700 dark:text-zinc-200">Cargo</label>
                    <input type="text" name="position" id="position" value="{{ old('position') }}"
                        class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white" />
                </div>
            </div>

            <div>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Guardar contacto
                </button>
            </div>
        </form>
    </div>
</x-layouts::app>
