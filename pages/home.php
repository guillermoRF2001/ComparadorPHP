<?php
include '../components/BDconfig.php';

// Iniciar sesión
session_start();

$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : "";
unset($_SESSION['msg']); // Limpiar el mensaje para futuras solicitudes





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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Header -->
    <?php include '../components/header.php'?>

    <!-- Main Content -->
    <div class="containerBody">
        <div class="row">
            <?php
            // Prepare the query to get the laptops for the current page
            $sql = "(SELECT id, nombre, precio, puntuacion, imgtext, 'portatil' AS categoria FROM portatil)
                    UNION
                    (SELECT id, nombre, precio, puntuacion, imgtext, 'Sobremesa' AS categoria FROM Sobremesa)
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
                    $imagen = $row['imgtext'];
                    $categoria = $row['categoria'];
                    echo '<div class="card">';
                    echo '<img class="imgCard" src="'.$imagen.'" alt="Imagen de '.$nombre.'" onerror="this.onerror=null; this.src=\'/ComparadorPHP/img/imgNoCarga.jpg\'">';
                    echo '<div class="card-details">';
                    echo '<h2><a href="/ComparadorPHP/pages/detalle.php?id='.$id.'&categoria='.$categoria.'">'.$nombre.'</a></h2>';
                    echo '<button class="botonComparar" data-id="'.$id.'" onclick="selectLaptop('.$id.', \''.$categoria.'\', this)"><img src="/ComparadorPHP/img/compare.png" alt="Comparador"></button>';
                    echo '</div>';
                    echo '<div class="stars">' . str_repeat('&#9733;', $puntuacion) . str_repeat('&#9734;', 5 - $puntuacion) . '</div>';
                    echo '</div>';
                }
            } else {
                echo "No se encontraron ordenadores.";
            }
            ?>
        </div>
    </div>
    <?php
    include '../components/pagination.php';
            // Obtener el número total de ordenadores
            $result = $conn->query("
            SELECT 'portatil' AS category, COUNT(*) AS total FROM portatil
            UNION
            SELECT 'sobremesa' AS category, COUNT(*) AS total FROM Sobremesa
            ");
            $total_items = 0;
            while ($row = $result->fetch_assoc()) {
                $total_items += $row['total'];
            }

            // Mostrar paginación
            renderPagination($page_number, $total_items, $items_per_page);

            if ($msg === "success") {
                echo '<script>Swal.fire("Éxito", "Ordenador eliminado con éxito", "success");</script>';
            } elseif ($msg === "error") {
                echo '<script>Swal.fire("Error", "Error al eliminar el ordenador. Verifica que el ID sea correcto.", "error");</script>';
            } elseif ($msg === "invalid") {
                echo '<script>Swal.fire("Error", "Datos de entrada no válidos", "error");</script>';
            } 
            
            
            if ($msg === "succesCreate") {
                echo '<script>Swal.fire("Éxito", "Ordenador creado con éxito", "success");</script>';
            } elseif ($msg === "invalidCreate") {
                echo '<script>Swal.fire("Error", "Ordenador no creado", "error");</script>';
            }




            // Close the connection
            $conn->close();
    ?>
</body>
</html>
