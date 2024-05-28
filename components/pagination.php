<?php
// pagination.php

function renderPagination($current_page, $total_items, $items_per_page = 20) {
    $total_pages = ceil($total_items / $items_per_page); // Calcular el número total de páginas

    // Ajustar el rango del bucle si estamos en la primera página
    $start_page = ($current_page <= 2) ? 1 : max(1, $current_page - 2);
    $end_page = ($current_page <= 2) ? min(5, $total_pages) : min($current_page + 2, $total_pages);

    // Mostrar el selector de página
    echo '<div class="pagination">';
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            echo "<span class='current'>$i</span>";
        } else {
            echo "<a href='?page=$i'>$i</a>";
        }
    }
    echo '</div>';
}
?>