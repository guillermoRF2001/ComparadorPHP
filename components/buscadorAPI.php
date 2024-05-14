<?php 
$opcion = "opcion2"; 
?>
 <?php include 'header.php'; ?>
<?php
$page_number = isset($_GET['page']) ? intval($_GET['page']) : 1; // Obtener el número de página actual de la URL

// Obtener los parámetros de búsqueda de la URL actual
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';
$consola = isset($_GET['consola']) ? $_GET['consola'] : '';

// Llamada a la API externa para obtener los juegos basados en los criterios de búsqueda
$api_url = "https://api.rawg.io/api/games?key=48b96e3384384217854a2dd35e1e8f08&page=$page_number";

// Agregar los parámetros de búsqueda a la URL si están definidos en la URL actual
if ($nombre!="") {
    $api_url .= "&search=" . urlencode($nombre); // URL encode para manejar espacios y caracteres especiales en el nombre
}

if (!empty($genre)) {
    $api_url .= "&genres=$genre";
}

if (!empty($consola)) {
    $api_url .= "&platforms=$consola";
}

// Realizar la solicitud a la API
$response = file_get_contents($api_url);
$data = json_decode($response);

// Verificar si se obtuvo una respuesta válida
if ($data && isset($data->results)) {
    // Mostrar los juegos y la paginación
    foreach (array_chunk($data->results, 4) as $row) {
        echo '<div class="row">';
        foreach ($row as $game) {
            echo '<div class="game">';
            if($game->background_image==null){
                echo '<img src="../img/imgNoCarga.jpg" alt="' . $game->name . '">';
            }else{
                echo '<img src="' . $game->background_image . '" alt="' . $game->name . '">';
            }
            echo '<p>' . htmlspecialchars($game->name) . '</p>';
            echo '</div>';
        }
        echo '</div>';
    }

    // Mostrar el selector de página
    echo '<div class="pagination">';
    $total_pages = $data->count / 20; // Suponiendo que cada página muestra 20 juegos

    // Ajustar el rango del bucle si estamos en la primera página
    $start_page = ($page_number <= 2) ? 1 : max(1, $page_number - 2);
    $end_page = ($page_number <= 2) ? min(5, $total_pages) : min($page_number + 2, $total_pages);

    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $page_number) {
            echo "<span class='current'>$i</span>";
        } else {
            // Construir la URL de la página con los parámetros de búsqueda actuales
            $page_url = "http://localhost/proyectoAPI/pages/buscador.php?nombre=$nombre&genre=$genre&consola=$consola&page=$i";
            echo "<a href='$page_url'>$i</a>";
        }
    }
    echo '</div>';
} else {
    echo "No se pudieron obtener los datos de la API.";
}

// Informacion Detallada
if ($data && isset($data->results)) {
    // Convertir los datos a formato JSON para enviarlos a JavaScript
    $games_json = json_encode($data->results);
?>
    <!-- JavaScript -->
    <script>
        // Obtener los datos de los juegos desde PHP
        var gamesData = <?php echo $games_json; ?>;

        // Agregar un evento de clic a cada elemento de juego
        var gameElements = document.querySelectorAll('.game');
        gameElements.forEach(function(gameElement, index) {
            gameElement.addEventListener('click', function() {
                var game = gamesData[index];
                var gameName = game.name;
                var gameImageSrc = game.background_image ? game.background_image : '../img/imgNoCarga.jpg';;
                var gameGenres = game.genres.map(function(genre) {
                    return genre.name;
                }).join(', ');
                var gameTags = game.tags.map(function(tag) {
                    return tag.name;
                }).join(', ');
                var gamePlatforms = game.platforms.map(function(platform) {
                    return platform.platform.name;
                }).join(', ');
                var releaseDate = game.released;
                var description = game.description || 'Descripción no disponible';
                console.log(gameTags);

                // Mostrar más información en una ventana modal
                var modalContent = `
                    <div class="modal-overlay" id="modalOverlay">
                        <div class="modal">
                            <img src="${gameImageSrc}" alt="${gameName}">
                            <h2>${gameName}</h2>
                            <p><strong>Géneros:</strong> ${gameGenres}</p>
                            <p><strong>Plataformas:</strong> ${gamePlatforms}</p>
                            <p><strong>Fecha de lanzamiento:</strong> ${releaseDate}</p>
                            <p><strong>Descripción:</strong> ${description}</p>
                            <p><strong>Tags:</strong> ${gameTags}</p>
                        </div>
                    </div>
                `;

                // Agregar la ventana modal al cuerpo del documento
                document.body.insertAdjacentHTML('beforeend', modalContent);

                // Agregar un evento de clic al overlay para cerrar la modal
                var modalOverlay = document.getElementById('modalOverlay');
                modalOverlay.addEventListener('click', function(event) {
                    if (event.target === modalOverlay) {
                        modalOverlay.parentNode.removeChild(modalOverlay);
                    }
                });
            });
        });
    </script>
<?php
} else {
    echo "<p>No se pudieron obtener los datos de la API.</p>";
}
?>