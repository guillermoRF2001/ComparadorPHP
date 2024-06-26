<?php
include '../components/BDconfig.php';

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    // Si no está autenticado, redirigir a la página de inicio de sesión
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

// Parámetros de paginación
$page_number = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 12;
$offset = ($page_number - 1) * $items_per_page;

// Definir el orden por defecto
$order_by = isset($_GET['type']) && $_GET['type'] == 'precio' ? 'precio ASC' : 'puntuacion DESC';

// Guardar el tipo de orden para usarlo en la paginación
$type = isset($_GET['type']) ? $_GET['type'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compu</title>
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
    <script src="/ComparadorPHP/scripts/selectComputer.js"></script>
</head>
<body>
    <!-- Header -->
    <?php include '../components/header.php'?>

    <!-- Main Content -->
    <div class="containerBody">
        <div class="row">
            <?php
            // Preparar la consulta para obtener los ordenadores de sobremesa de la página actual
            $sql = "
            SELECT id, nombre, precio, puntuacion, imgtext, 'Sobremesa' AS categoria FROM Sobremesa
            ORDER BY $order_by
            LIMIT $items_per_page OFFSET $offset";

            $result = $conn->query($sql);

            // Verificar si hay ordenadores de sobremesa en el resultado
            if ($result->num_rows > 0) {
                // Loop para mostrar cada ordenador de sobremesa
                while($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $nombre = $row['nombre'];
                    $puntuacion = $row['puntuacion'];
                    $imagen = $row['imgtext'];
                    $categoria = $row['categoria'];
                    echo '<div class="card">';
                    echo '<img class="imgCard" src="'.$imagen.'" alt="Imagen de '.$nombre.'" onerror="this.onerror=null; this.src=\'/ComparadorPHP/img/imgNoCarga.jpg\'">';
                    echo '<div class="card-details">';
                    echo '<h2><a href="/ComparadorPHP/pages/detalle.php?id='.$id.'&categoria=Sobremesa">'.$nombre.'</a></h2>';
                    echo '<button class="botonComparar"  id="button-'.$id.'" onclick="selectLaptop('.$id.', \''.$categoria.'\', this)"><img src="/ComparadorPHP/img/compare.png" alt="Comparador"></button>';
                    echo '</div>';
                    echo '<div class="stars">' . str_repeat('&#9733;', $puntuacion) . str_repeat('&#9734;', 5 - $puntuacion) . '</div>';
                    echo '</div>';
                }
            } else {
                echo "No se encontraron ordenadores de sobremesa.";
            }
            ?>
        </div>
    </div>
    <?php
    include '../components/pagination.php';
            // Obtener el número total de ordenadores de sobremesa
            $result = $conn->query("SELECT COUNT(*) as total FROM Sobremesa");
            $total_items = $result->fetch_assoc()['total'];

            // Mostrar paginación
            renderPagination($page_number, $total_items, $items_per_page, $type);

            // Cerrar la conexión
            $conn->close();
    ?>
</body>
</html>
