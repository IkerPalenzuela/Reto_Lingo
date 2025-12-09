<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estadistica;
use Illuminate\Support\Facades\Auth;

class EstadisticaController extends Controller
{
    /**
     * Mostrar todas las estadísticas.
     */
    public function index()
    {
        // Trae las estadísticas de todos los jugadores junto con su usuario
        $estadisticas = Estadistica::with('user')->get();

        return view('estadisticas', compact('estadisticas'));
    }

    /**
     * Guardar la racha de victorias del usuario.
     */
    public function guardarRacha(Request $request)
    {
        $request->validate([
            'racha' => 'required|integer|min:1',
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Crear la estadística si no existe o sumar la racha a la existente
        $estadistica = Estadistica::firstOrCreate(
            ['user_id' => $user->id],
            ['partidas_ganadas' => 0]
        );

        $estadistica->partidas_ganadas += $request->racha;
        $estadistica->save();

        return response()->json([
            'success' => true,
            'partidas_ganadas' => $estadistica->partidas_ganadas
        ]);
    }
}
