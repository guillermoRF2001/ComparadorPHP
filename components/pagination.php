<?php
// pagination.php

function renderPagination($current_page, $total_items, $items_per_page = 20, $type = '', $pc = '', $search = '') {
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
            $url = "?page=$i&type=$type";
            if (!empty($pc)) {
                $url .= "&pc=$pc";
            }
            if (!empty($search)) {
                $url .= "&search=$search";
            }
            echo "<a href='$url'>$i</a>";
        }
    }
    echo '</div>';
}
