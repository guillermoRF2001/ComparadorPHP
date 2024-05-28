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
            $sql = "(SELECT id, nombre, precio, puntuacion, imagen FROM portatil)
            UNION
            (SELECT id, nombre, precio, puntuacion, imagen FROM Sobremesa)
            ORDER BY puntuacion DESC
            LIMIT $items_per_page OFFSET $offset";

            $result = $conn->query($sql);

            // Check if there are any laptops in the result
            if ($result->num_rows > 0) {
                // Loop through each laptop and display it
                while($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $nombre = $row['nombre'];
                    $puntuacion = $row['puntuacion'];
                    $imagen = base64_encode($row['imagen']);
                    echo '<div class="card">';
                    echo '<img class="imgCard" src="data:image/jpeg;base64,'.$imagen.'" alt="Imagen de '.$nombre.'">';
                    echo '<div class="card-details">';
                    echo '<h2>'.$nombre.'</h2>';
                    echo '<button class="botonComparar"  id="button-'.$id.'" onclick="selectLaptop('.$id.', this)"><img src="/ComparadorPHP/img/compare.png" alt="Comparador"></button>';
                    echo '</div>';
                    echo '<div class="stars">' . str_repeat('&#9733;', $puntuacion) . str_repeat('&#9734;', 5 - $puntuacion) . '</div>';
                    echo '</div>';
                }
            } else {
                echo "No se encontraron portátiles.";
            }
            ?>
        </div>
    </div>
    <?php
    include '../components/pagination.php';
            // Obtener el número total de portátiles
            $result = $conn->query("SELECT COUNT(*) as total FROM portatil");
            $total_items = $result->fetch_assoc()['total'];

            // Mostrar paginación
            renderPagination($page_number, $total_items, $items_per_page);

            // Close the connection
            $conn->close();
    ?>
</body>
</html>
