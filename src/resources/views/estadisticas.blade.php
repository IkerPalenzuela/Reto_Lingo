<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Estadísticas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-center">Jugador</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Partidas Ganadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estadisticas as $e)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $e->user->name }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $e->partidas_ganadas }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
