<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lingo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/lingo.css', 'resources/js/lingo.js'])
</head>
<body>
    <header>
        <img src="{{ Vite::asset('resources/images/Logo.png') }}" alt="Logo">
        <nav class="menu">
            <div>Juego</div>
        </nav>
    </header>
    <main>
        <div id="temporizador" class="temporizador">15</div>
        <h2 id="racha" class="racha">Racha: 0</h2>
        <div id="tablaPalabras" class="palabras"></div><br>
        <div id="tablaLetras" class="teclado"></div>

        <button id="boton-reiniciar" class="boton-reiniciar" style="display: none;">Jugar de nuevo</button>

        <!-- Formulario oculto para enviar racha a Laravel -->
        <form id="formRacha" action="/guardar-racha" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="racha" id="inputRacha">
        </form>
    </main>
    <footer>
        <p> &copy Reto_Lingo 2025</p>
    </footer>
</body>
</html>
