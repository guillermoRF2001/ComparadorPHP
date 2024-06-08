<?php
include '../components/BDconfig.php';

// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['idUsuario']) || $_SESSION['role'] !== 'admin') {
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

// Obtener el ID del ordenador y la categoría desde el parámetro GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

if ($id > 0 && in_array($categoria, ['portatil', 'Sobremesa'])) {
    // Preparar la consulta para eliminar el ordenador
    if ($categoria === 'portatil') {
        $stmt = $conn->prepare("DELETE FROM portatil WHERE id = ?");
    } elseif ($categoria === 'Sobremesa') {
        $stmt = $conn->prepare("DELETE FROM Sobremesa WHERE id = ?");
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirigir con mensaje de éxito
        $_SESSION['msg'] = "success";
    } else {
        // Redirigir con mensaje de error
        $_SESSION['msg'] = "error";
    }

    $stmt->close();
} else {
    // Redirigir con mensaje de entrada no válida
    $_SESSION['msg'] = "invalid";
}

// Cerrar la conexión a la base de datos
$conn->close();
header("Location: /ComparadorPHP/pages/home.php");
exit;
?>