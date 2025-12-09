document.addEventListener('DOMContentLoaded', () => {
    const N = 5;
    let filaActual = 0;
    let colActual = 0;
    let juegoTerminado = false;
    let palabra = "";
    let timerInterval;
    let tiempoRestante = 15;
    let rachaVictoriasActual = 0;

    const contenedor = document.getElementById("tablaPalabras");
    const tiempo = document.getElementById("temporizador");
    const racha = document.getElementById("racha");
    const botonReiniciar = document.getElementById("boton-reiniciar");
    const contenedorTeclado = document.getElementById("tablaLetras");

    async function obtenerPalabra() {
        try {
            const respuesta = await fetch("http://185.60.43.155:3000/api/word/1");
            const datos = await respuesta.json();
            palabra = datos.word.toUpperCase();
            console.log("Palabra a adivinar:", palabra);
        } catch (error) {
            console.error("Error al obtener la palabra:", error);
            throw new Error("No se pudo cargar la palabra");
        }
    }

    async function verificarPalabra(palabraUsuario) {
        try {
            const respuesta = await fetch(`http://185.60.43.155:3000/api/check/${palabraUsuario}`);
            const datos = await respuesta.json();
            return datos.exists;
        } catch (error) {
            console.error("Error al verificar la palabra:", error);
            return false;
        }
    }

    async function iniciarNuevaPartida() {
        filaActual = 0;
        colActual = 0;
        juegoTerminado = false;
        if (botonReiniciar) botonReiniciar.style.display = 'none';
        if (contenedor) {
            for (let i = 0; i < N; i++) {
                for (let j = 0; j < N; j++) {
                    const celda = document.getElementById(`celda-${i}-${j}`);
                    if (celda) {
                        celda.innerHTML = "";
                        celda.letra = "";
                    }
                }
            }
        }

        try {
            await obtenerPalabra();
        } catch (error) {
            alert("Error al cargar la siguiente palabra. El juego se detendrá.");
            return;
        }
        iniciarContador();
    }

    function iniciarContador() {
        clearInterval(timerInterval);
        tiempoRestante = 15;
        if (tiempo) tiempo.textContent = tiempoRestante;

        timerInterval = setInterval(() => {
            if (juegoTerminado) {
                clearInterval(timerInterval);
                return;
            }
            tiempoRestante--;
            if (tiempo) tiempo.textContent = tiempoRestante;

            if (tiempoRestante <= 0) {
                clearInterval(timerInterval);
                pasarSiguienteFilaPorTiempo();
            }
        }, 1000);
    }

    function pasarSiguienteFilaPorTiempo() {
        if (juegoTerminado) return;
        filaActual++;
        colActual = 0;

        if (filaActual >= N) {
            juegoTerminado = true;
            alert(`¡Tiempo agotado! La palabra era: ${palabra}.`);
            if (tiempo) tiempo.textContent = "0";
            manejarDerrota();
        } else {
            iniciarContador();
        }
    }

    if (contenedor && contenedor.children.length === 0) {
        for (let i = 0; i < N; i++) {
            for (let j = 0; j < N; j++) {
                const celda = document.createElement("div");
                celda.id = `celda-${i}-${j}`;
                contenedor.appendChild(celda);
            }
        }
    }

    const letras = [
        ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'],
        ['A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Ñ'],
        ['Z', 'X', 'C', 'V', 'B', 'N', 'M']
    ];

    if (contenedorTeclado && contenedorTeclado.children.length == 0) {
        letras.forEach((fila) => {
            fila.forEach((letra) => {
                const tecla = document.createElement("div");
                if (letra !== '') {
                    const img = document.createElement("img");
                    img.src = `/Letras/Txikiak/${letra}NT.png`;
                    img.alt = letra;
                    img.addEventListener("click", () => escribirLetra(letra));
                    tecla.appendChild(img);
                } else {
                    tecla.classList.add('tecla-vacia');
                }
                contenedorTeclado.appendChild(tecla);
            });
        });
    }

    function escribirLetra(letra) {
        if (juegoTerminado) return;

        if (colActual < N) {
            const idCelda = `celda-${filaActual}-${colActual}`;
            const celda = document.getElementById(idCelda);
            if (celda) {
                celda.letra = letra;
                celda.innerHTML = `<img src="/Letras/Naranja/${letra}N.png" alt="${letra}">`;
            }
            colActual++;
            if (colActual === N) {
                clearInterval(timerInterval);
                cambiarLetra(filaActual);
            }
        }
    }
    window.escribirLetra = escribirLetra;

    async function cambiarLetra(filaAValidar) {
        let palabraUsuario = "";
        let estados = new Array(N);
        let letrasPalabra = palabra.split('');
        for (let i = 0; i < N; i++) {
            const idCelda = `celda-${filaAValidar}-${i}`;
            const celda = document.getElementById(idCelda);
            palabraUsuario += celda.letra;
        }

        const existe = await verificarPalabra(palabraUsuario.toLowerCase());

        if (!existe) {
            alert("Esa palabra no existe en el diccionario. Pierdes el turno.");
            if (filaAValidar === N - 1) {
                juegoTerminado = true;
                alert(`...y era tu último intento. La palabra era: ${palabra}.`);
                manejarDerrota();
            } else {
                filaActual++;
                colActual = 0;
                iniciarContador();
            }
            return;
        }

        for (let i = 0; i < N; i++) {
            const idCelda = `celda-${filaAValidar}-${i}`;
            const celda = document.getElementById(idCelda);
            const letraUsuario = celda.letra;
            if (palabra[i] === letraUsuario) {
                estados[i] = "Verde";
                letrasPalabra[i] = null;
            }
        }

        for (let i = 0; i < N; i++) {
            if (estados[i] === "Verde") continue;
            const idCelda = `celda-${filaAValidar}-${i}`;
            const celda = document.getElementById(idCelda);
            const letraUsuario = celda.letra;
            let indiceEnPalabra = letrasPalabra.indexOf(letraUsuario);
            if (indiceEnPalabra !== -1) {
                estados[i] = "Naranja";
                letrasPalabra[indiceEnPalabra] = null;
            } else {
                estados[i] = "Rojo";
            }
        }

        for (let i = 0; i < N; i++) {
            const idCelda = `celda-${filaAValidar}-${i}`;
            const celda = document.getElementById(idCelda);
            const letraUsuario = celda.letra;
            if (estados[i] === "Verde") {
                celda.innerHTML = `<img src="/Letras/Verde/${letraUsuario}V.png" alt="${letraUsuario}">`;
            } else if (estados[i] === "Naranja") {
                celda.innerHTML = `<img src="/Letras/Naranja/${letraUsuario}N.png" alt="${letraUsuario}">`;
            } else {
                celda.innerHTML = `<img src="/Letras/Rojo/${letraUsuario}R.png" alt="${letraUsuario}">`;
            }
        }

        if (palabraUsuario === palabra) {
            juegoTerminado = true;
            rachaVictoriasActual++;
            if (racha) racha.textContent = `Racha: ${rachaVictoriasActual}`;
            setTimeout(iniciarNuevaPartida, 1000);
        } else if (filaAValidar === N - 1) {
            juegoTerminado = true;
            alert(`Fin del juego. La palabra era: ${palabra}.`);
            manejarDerrota();
        } else {
            filaActual++;
            colActual = 0;
            iniciarContador();
        }
    }

    // Versión sencilla para principiantes: guardamos la racha usando un formulario
    function guardarRachaEnBD(racha) {
        document.getElementById('inputRacha').value = racha;
        document.getElementById('formRacha').submit();
    }

    function manejarDerrota() {
        juegoTerminado = true;
        clearInterval(timerInterval);

        if (rachaVictoriasActual > 0) {
            guardarRachaEnBD(rachaVictoriasActual);
            alert(`¡Fin de la racha! Has conseguido ${rachaVictoriasActual} victorias.`);
        }

        rachaVictoriasActual = 0;
        if (racha) racha.textContent = `Racha: ${rachaVictoriasActual}`;
        if (botonReiniciar) botonReiniciar.style.display = 'block';
    }

    if (botonReiniciar) {
        botonReiniciar.addEventListener('click', () => {
            iniciarNuevaPartida();
        });
    }

    iniciarNuevaPartida();
});