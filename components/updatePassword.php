<?php
require '../clases/Database.php';
require '../clases/Usuario.php';

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    // Si no está autenticado, redirigir a la página de inicio de sesión
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $idUsuario = $_SESSION['idUsuario'];

    // Crear una instancia de la clase Usuario
    $db = new Database();
    $usuario = new Usuario($db);

    // Obtener los datos del usuario actual por su ID
    $userData = $usuario->obtenerUsuarioPorId($idUsuario);

    if ($userData) {
        // Verificar si la contraseña coincide
        if (password_verify($oldPassword, $userData['password'])) {
            // Actualizar la contraseña
            if ($usuario->actualizarPassword($idUsuario, $newPassword)) {
                // Contraseña actualizada correctamente
                session_start();
                session_unset();
                session_destroy();
                header("Location: /ComparadorPHP/pages/PHPLogin.php?success=Contraseña+actualizada+correctamente");
                exit;
            } else {
                // Error al ejecutar la actualización
                header("Location: /ComparadorPHP/pages/changePassword.php?error=Error+al+actualizar+la+contraseña");
            }
        } else {
            // La contraseña no coincide
            header("Location: /ComparadorPHP/pages/changePassword.php?error=Contraseña+antigua+incorrecta");
        }
    } else {
        // Usuario no encontrado
        header("Location: /ComparadorPHP/pages/changePassword.php?error=Usuario+no+encontrado");
    }
}
?>
