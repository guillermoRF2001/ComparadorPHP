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

if (isset($_GET['id1']) && isset($_GET['id2'])) {
    $id1 = $_GET['id1'];
    $id2 = $_GET['id2'];

    // Consultar los detalles de los dos portátiles
    $sql1 = "SELECT * FROM portatil WHERE id = $id1";
    $sql2 = "SELECT * FROM portatil WHERE id = $id2";

    $result1 = $conn->query($sql1);
    $result2 = $conn->query($sql2);

    if ($result1->num_rows > 0 && $result2->num_rows > 0) {
        $laptop1 = $result1->fetch_assoc();
        $laptop2 = $result2->fetch_assoc();
        // Mostrar los detalles de los dos portátiles para la comparación
        echo '<div class="comparison">';
        echo '<div class="laptop">';
        echo '<h2>'.$laptop1['nombre'].'</h2>';
        echo '<img src="data:image/jpeg;base64,'.base64_encode($laptop1['imagen']).'" alt="Imagen de '.$laptop1['nombre'].'">';
        echo '<p>Precio: '.$laptop1['precio'].'</p>';
        echo '<p>Puntuación: '.$laptop1['puntuacion'].'</p>';
        echo '</div>';
        echo '<div class="laptop">';
        echo '<h2>'.$laptop2['nombre'].'</h2>';
        echo '<img src="data:image/jpeg;base64,'.base64_encode($laptop2['imagen']).'" alt="Imagen de '.$laptop2['nombre'].'">';
        echo '<p>Precio: '.$laptop2['precio'].'</p>';
        echo '<p>Puntuación: '.$laptop2['puntuacion'].'</p>';
        echo '</div>';
        echo '</div>';
    } else {
        echo "No se encontraron detalles de los portátiles.";
    }
} else {
    echo "No se han proporcionado los IDs de los portátiles.";
}

// Close the connection
$conn->close();
?>
