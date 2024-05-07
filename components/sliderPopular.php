<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>WikiGames</title>
    <script>
        <?php

        // URL de la API
        $url = 'https://rawg.io/api/games/?key=48b96e3384384217854a2dd35e1e8f08&metacritic=80,100&page_size=8';

        // Obtener los datos de la API
        $response = file_get_contents($url);

        // Decodificar los datos JSON
        $data = json_decode($response, true);

        // Array para almacenar las imágenes y nombres de los videojuegos
        $imagenesCarrusel = [];
        $nombresCarrusel = [];

        // Verificar si se obtuvieron datos válidos
        if ($data && isset($data['results'])) {
            // Iterar sobre los resultados
            foreach ($data['results'] as $result) {
                // Obtener la imagen y el nombre del videojuego
                $imagen = $result['background_image'] ?  $result['background_image'] : '../img/imgNoCarga.jpg';
                $nombre = $result['name'];
                $imagenesCarrusel[] = $imagen;
                $nombresCarrusel[] = $nombre;
            }
        }

        ?>
        window.onload = function () {
            // Variables
            const IMAGENES = <?php echo json_encode($imagenesCarrusel); ?>;
            const NOMBRES = <?php echo json_encode($nombresCarrusel); ?>;
            const TIEMPO_INTERVALO_MILESIMAS_SEG = 5000; // Cambiado a 5 segundos
            let posicionActual = 0;
            let $botonRetroceder = document.querySelector('#retroceder');
            let $botonAvanzar = document.querySelector('#avanzar');
            let $imagen = document.querySelector('#imagen');
            let $nombreJuego = document.querySelector('#nombre-juego');
            let intervalo;

            // Funciones

            /**
             * Funcion que cambia la foto en la siguiente posicion
             */
            function pasarFoto() {
                if(posicionActual >= IMAGENES.length - 1) {
                    posicionActual = 0;
                } else {
                    posicionActual++;
                }
                renderizarImagen();
            }

            /**
             * Funcion que cambia la foto en la anterior posicion
             */
            function retrocederFoto() {
                if(posicionActual <= 0) {
                    posicionActual = IMAGENES.length - 1;
                } else {
                    posicionActual--;
                }
                renderizarImagen();
            }

            /**
             * Funcion que actualiza la imagen de imagen dependiendo de posicionActual
             */
            function renderizarImagen () {
                $imagen.style.backgroundImage = `url(${IMAGENES[posicionActual]})`;
                $nombreJuego.textContent = NOMBRES[posicionActual]; // Mostrar el nombre del juego
            }

            /**
             * Activa el autoplay de la imagen
             */
            function startAutoplay() {
                intervalo = setInterval(pasarFoto, TIEMPO_INTERVALO_MILESIMAS_SEG);
            }

            // Eventos
            $botonAvanzar.addEventListener('click', function() {
                clearInterval(intervalo); // Resetear el intervalo
                pasarFoto();
                startAutoplay(); // Reiniciar el autoplay
            });
            $botonRetroceder.addEventListener('click', function() {
                clearInterval(intervalo); // Resetear el intervalo
                retrocederFoto();
                startAutoplay(); // Reiniciar el autoplay
            });
            // Iniciar
            renderizarImagen();
            startAutoplay(); // Iniciar autoplay al cargar la página
        }
    </script>
</head>

<body>

<div class="carousel">
    <button id="retroceder"><img src="/proyectoAPI/img/botonRetroceder.png" alt="Retroceder"></button>
    <div id="imagen-container">
        <div id="imagen"></div>
        <div id="nombre-juego"></div>
    </div>
    <button id="avanzar"><img src="/proyectoAPI/img/botonAvance.png" alt="Avance"></button>
</div>

</body>
</html>