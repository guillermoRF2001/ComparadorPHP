<?php
$page_number = isset($_GET['page']) ? intval($_GET['page']) : 1; // Obtener el número de página actual de la URL

// Llamada a la API externa para obtener los juegos más populares
$api_url = "https://api.rawg.io/api/games?key=48b96e3384384217854a2dd35e1e8f08&ordering=released&page=$page_number";
$response = file_get_contents($api_url);
$data = json_decode($response);

// Verificar si se obtuvo una respuesta válida
if ($data && isset($data->results)) {
    // Mostrar los juegos en filas de cuatro
    foreach (array_chunk($data->results, 4) as $row) {
        echo '<div class="row">';
        foreach ($row as $game) {
            echo '<div class="game">';
            if($game->background_image==null){
                echo '<img src="../img/imgNoCarga.jpg" alt="' . $game->name . '">';
            }else{
                echo '<img src="' . $game->background_image . '" alt="' . $game->name . '">';
            }
            echo '<p>' . $game->name . '</p>';
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
            echo "<a href='?page=$i'>$i</a>";
        }
    }
    echo '</div>';
}
?>