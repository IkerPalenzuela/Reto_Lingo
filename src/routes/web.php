<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LingoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PalabraController;
use App\Http\Controllers\EstadisticaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de palabras
    Route::get('/palabras', [PalabraController::class, 'index'])->name('palabras.index');
    Route::get('/palabrasStyled', [PalabraController::class, 'indexStyled'])->name('palabras.indexStyled');
    Route::get('/palabrasBlade', [PalabraController::class, 'indexBlade'])->name('palabras.indexBlade');

    // Juego y estadísticas
    Route::get('/juego', fn () => view('lingo'))->name('lingo');
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas');

    // NUEVA RUTA: Guardar racha del usuario
    Route::post('/guardar-racha', [EstadisticaController::class, 'guardarRacha'])->name('guardar-racha');
});

require __DIR__.'/auth.php';
