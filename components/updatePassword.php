<?php
// Incluir el archivo de configuración
include './BDconfig.php';

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

    // Preparar la consulta SQL para seleccionar el usuario por su ID
    $sql = "SELECT password FROM usuario WHERE idUsuario = ?";

    // Preparar la declaración
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "s", $idUsuario);

        // Ejecutar la declaración
        if (mysqli_stmt_execute($stmt)) {
            // Obtener el resultado de la consulta
            $result = mysqli_stmt_get_result($stmt);

            // Verificar si se encontró un usuario con el ID dado
            if ($row = mysqli_fetch_assoc($result)) {
                // Verificar si la contraseña coincide
                if (password_verify($oldPassword, $row['password'])) {
                    // Generar el hash de la nueva contraseña
                    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Preparar la consulta SQL para actualizar la contraseña
                    $updateSql = "UPDATE usuario SET password = ? WHERE idUsuario = ?";
                    $updateStmt = mysqli_prepare($conn, $updateSql);

                    if ($updateStmt) {
                        // Vincular los parámetros
                        mysqli_stmt_bind_param($updateStmt, "ss", $newHashedPassword, $idUsuario);

                        // Ejecutar la declaración
                        if (mysqli_stmt_execute($updateStmt)) {
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

                        // Cerrar la declaración de actualización
                        mysqli_stmt_close($updateStmt);
                    } else {
                        // Error al preparar la declaración de actualización
                        echo "Error al preparar la declaración de actualización: " . mysqli_error($conn);
                    }
                } else {
                    // La contraseña no coincide
                    header("Location: /ComparadorPHP/pages/changePassword.php?error=Contraseña+antigua+incorrecta");
                }
            } else {
                // Usuario no encontrado
                header("Location: /ComparadorPHP/pages/changePassword.php?error=Usuario+no+encontrado");
            }
        } else {
            // Error al ejecutar la consulta
            header("Location: /ComparadorPHP/pages/changePassword.php?error=Error+al+ejecutar+la+consulta+inténtelo+más+tarde");
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        // Error al preparar la declaración
        echo "Error al preparar la declaración: " . mysqli_error($conn);
    }

    // Cerrar la conexión
    mysqli_close($conn);
}
?>