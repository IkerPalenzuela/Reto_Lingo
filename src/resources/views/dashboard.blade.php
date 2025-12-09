<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">
                        ¡Bienvenido a Lingo!
                    </h3>
                    <p class="mb-6">
                        ¿Qué quieres hacer?
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('lingo') }}"
                        style="background:#2563eb;color:white;padding:10px 18px;border-radius:6px;text-decoration:none;display:inline-block;font-weight:600">
                        Jugar a Lingo
                        </a>

                        <a href="{{ route('estadisticas') }}"
                        style="background:#4b5563;color:white;padding:10px 18px;border-radius:6px;text-decoration:none;display:inline-block;font-weight:600">
                        Ver Estadísticas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>