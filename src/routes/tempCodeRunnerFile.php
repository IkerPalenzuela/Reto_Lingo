<?php
lve de la tabla 'palabras' una palabra aleatoria
    Route::get('/palabrasRandom/', [LingoController::class, 'indexRandom'])->name('lingos.indexRandom');

    Route::get('VerificarPalabra/{palabra}', [LingoController::class, 'verificarPalabra'])
    ->middleware(['auth', 'verified'])
    ->name('lingos.verificarPalabra');