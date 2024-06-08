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

// Verificar si los datos del formulario fueron enviados
if (isset($_POST['puntuacion']) && isset($_POST['comentario'])) {
    // Obtener los datos del formulario
    $puntuacion = $_POST['puntuacion']; // Suponiendo que la puntuación se envía mediante POST
    $opinion = $_POST['comentario']; // Suponiendo que el comentario se envía mediante POST
    $idUsuario = $_SESSION['idUsuario']; // Obtener el ID del usuario de la sesión

    // Preparar la consulta para insertar el comentario en la base de datos
    $sql = "INSERT INTO comentarios (idUsuario, puntuacion, opinion) VALUES (?, ?, ?)";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Vincular parámetros
        $stmt->bind_param("iis", $idUsuario, $puntuacion, $opinion);

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // Comentario guardado exitosamente
            echo "Comentario guardado correctamente.";
            $_SESSION['msg'] = "correct";
        } else {
            // Error al guardar el comentario
            echo "Error al guardar el comentario.";
            $_SESSION['msg'] = "invalid";
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        // Error en la preparación de la consulta
        $_SESSION['msg'] = "invalid";
        echo "Error en la preparación de la consulta.";
    }
} else {
    // Error: Datos del formulario no recibidos
    $_SESSION['msg'] = "invalid";
    echo "Error: Datos del formulario no recibidos.";
}

// Cerrar la conexión
header("Location: /ComparadorPHP/pages/writeComentarios.php");
$conn->close();
