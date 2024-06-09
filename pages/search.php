<?php
include '../components/BDconfig.php';

// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    // Si no está autenticado, redirigir a la página de inicio de sesión
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

// El usuario está autenticado, puedes mostrar el contenido protegido aquí

$page_number = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 12;
$offset = ($page_number - 1) * $items_per_page;
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
            // Prepare the query to get the laptops for the current page
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $categoria = isset($_GET['pc']) ? $_GET['pc'] : '';
                $busqueda = isset($_GET['search']) ? $_GET['search'] : '';

                if (!empty($categoria) && !empty($busqueda)) {
                    // Consultar los productos de la categoría seleccionada que coincidan con el término de búsqueda
                    $stmt = $conn->prepare("SELECT id, nombre, precio, puntuacion, imgtext FROM $categoria WHERE nombre LIKE ? LIMIT ? OFFSET ?");
                    $like_busqueda = "%$busqueda%";
                    $stmt->bind_param("sii", $like_busqueda, $items_per_page, $offset);
                } elseif (!empty($categoria) && empty($busqueda)) {
                    // Consultar los productos de la categoría seleccionada
                    $stmt = $conn->prepare("SELECT id, nombre, precio, puntuacion, imgtext FROM $categoria LIMIT ? OFFSET ?");
                    $stmt->bind_param("ii", $items_per_page, $offset);
                } elseif (empty($categoria) && !empty($busqueda)) {
                    // Consultar los productos de todas las categorías que coincidan con el término de búsqueda
                    $stmt = $conn->prepare("
                        (SELECT id, nombre, precio, puntuacion, imgtext, 'portatil' AS categoriaPC FROM portatil WHERE nombre LIKE ?)
                        UNION
                        (SELECT id, nombre, precio, puntuacion, imgtext, 'Sobremesa' AS categoriaPC FROM Sobremesa WHERE nombre LIKE ?)
                        ORDER BY puntuacion DESC
                        LIMIT ? OFFSET ?");
                    $like_busqueda = "%$busqueda%";
                    $stmt->bind_param("ssii", $like_busqueda, $like_busqueda, $items_per_page, $offset);
                } else {
                    // Consultar los productos de todas las categorías
                    $stmt = $conn->prepare("
                        (SELECT id, nombre, precio, puntuacion, imgtext, 'portatil' AS categoriaPC FROM portatil)
                        UNION
                        (SELECT id, nombre, precio, puntuacion, imgtext, 'Sobremesa' AS categoriaPC FROM Sobremesa)
                        ORDER BY puntuacion DESC
                        LIMIT ? OFFSET ?");
                    $stmt->bind_param("ii", $items_per_page, $offset);
                }

                $stmt->execute();
                $result = $stmt->get_result();
            
                if($result->num_rows > 0 && !empty($categoria)) {
                    while($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $nombre = $row['nombre'];
                        $puntuacion = $row['puntuacion'];
                        $imagen = $row['imgtext'];
                        echo '<div class="card">';
                        echo '<img class="imgCard" src="'.$imagen.'" alt="Imagen de '.$nombre.'">';
                        echo '<div class="card-details">';
                        echo '<h2><a href="/ComparadorPHP/pages/detalle.php?id='.$id.'&categoria='.$categoria.'">'.$nombre.'</a></h2>';
                        echo '<button class="botonComparar" data-id="'.$id.'" onclick="selectLaptop('.$id.', \''.$categoria.'\', this)"><img src="/ComparadorPHP/img/compare.png" alt="Comparador"></button>';
                        echo '</div>';
                        echo '<div class="stars">' . str_repeat('&#9733;', $puntuacion) . str_repeat('&#9734;', 5 - $puntuacion) . '</div>';
                        echo '</div>';
                    }
                }elseif ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $nombre = $row['nombre'];
                        $puntuacion = $row['puntuacion'];
                        $imagen = $row['imgtext'];
                        $categoriaPC = $row['categoriaPC'];
                        echo '<div class="card">';
                        echo '<img class="imgCard" src="'.$imagen.'" alt="Imagen de '.$nombre.'">';
                        echo '<div class="card-details">';
                        echo '<h2><a href="/ComparadorPHP/pages/detalle.php?id='.$id.'&categoria='.$categoriaPC.'">'.$nombre.'</a></h2>';
                        echo '<button class="botonComparar" data-id="'.$id.'" onclick="selectLaptop('.$id.', \''.$categoriaPC.'\', this)"><img src="/ComparadorPHP/img/compare.png" alt="Comparador"></button>';
                        echo '</div>';
                        echo '<div class="stars">' . str_repeat('&#9733;', $puntuacion) . str_repeat('&#9734;', 5 - $puntuacion) . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No se encontraron productos.";
                }

                $stmt->close();

                // Obtener el número total de elementos para la paginación
                if (!empty($categoria) && !empty($busqueda)) {
                    $stmt_count = $conn->prepare("SELECT COUNT(*) as total FROM $categoria WHERE nombre LIKE ?");
                    $stmt_count->bind_param("s", $like_busqueda);
                } elseif (!empty($categoria)) {
                    $stmt_count = $conn->prepare("SELECT COUNT(*) as total FROM $categoria");
                } elseif (!empty($busqueda)) {
                    $stmt_count = $conn->prepare("
                        SELECT COUNT(*) as total FROM (
                            SELECT id FROM portatil WHERE nombre LIKE ?
                            UNION ALL
                            SELECT id FROM Sobremesa WHERE nombre LIKE ?
                        ) AS combined");
                    $stmt_count->bind_param("ss", $like_busqueda, $like_busqueda);
                } else {
                    $stmt_count = $conn->prepare("
                        SELECT COUNT(*) as total FROM (
                            SELECT id FROM portatil
                            UNION ALL
                            SELECT id FROM Sobremesa
                        ) AS combined");
                }

                $stmt_count->execute();
                $result_count = $stmt_count->get_result();
                $total_items = $result_count->fetch_assoc()['total'];
                $stmt_count->close();
            }
            ?>
        </div>
    </div>
    <?php
    include '../components/pagination.php';
    // Mostrar paginación
    renderPagination($page_number, $total_items, $items_per_page, '', $categoria, $busqueda);
    ?>
</body>
</html>
