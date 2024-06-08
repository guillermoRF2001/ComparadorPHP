<?php
// Incluir el archivo de configuración de la base de datos
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

// Obtener el ID del usuario de la sesión
$idUsuario = $_SESSION['idUsuario'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Compu</title>
</head>
<body>
<?php include '../components/header.php'?>


<?php
// Consulta SQL para seleccionar todas las opiniones
$sql = "SELECT u.email, c.puntuacion, c.opinion, c.fecha 
        FROM comentarios c 
        INNER JOIN usuario u ON c.idUsuario = u.idUsuario";

// Preparar la consulta
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();

    // Comprobar si se encontraron opiniones
    if ($result->num_rows > 0) {
        // Mostrar las opiniones
        echo '<div class="containerBody">';
        while ($row = $result->fetch_assoc()) {
            $puntuacion = $row['puntuacion'];
            echo '<div class="comentCard">';
            echo '<div class="comInicio">';
            echo '<div class="userEmail"><i class="fa-regular fa-user"></i> ' . $row['email'] . '</div>';
            echo '<div class="stars">' . str_repeat('&#9733;', $puntuacion) . str_repeat('&#9734;', 5 - $puntuacion) . '</div>';
            echo '</div>';
            echo $row['opinion'];
            echo '<div class="comFecha"><i class="fa-regular fa-calendar-days"></i>' . $row['fecha']."</div>";
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "No hay opiniones registradas.";
    }

    // Cerrar la consulta
    $stmt->close();
} else {
    echo "Error en la preparación de la consulta.";
}

// Cerrar la conexión
$conn->close();
?>

</body>
</html>
