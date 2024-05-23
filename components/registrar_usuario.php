<?php
// Incluir el archivo de configuración
include './BDconfig.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $email = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // Verificar que las contraseñas coincidan
    if ($password !== $password2) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden'
                }).then(() => {
                    window.history.back();
                });
              </script>";
        exit;
    }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta SQL
    $sql = "INSERT INTO usuario (email, password, role) VALUES (?, ?, 'user')";

    // Preparar la declaración
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);

        // Ejecutar la declaración
        try {
            if (mysqli_stmt_execute($stmt)) {
                // Redirigir al usuario a PHPLogin.php
                header("Location: /ComparadorPHP/pages/PHPLogin.php");
                exit;
            }
        } catch (mysqli_sql_exception $exception) {
            // Verificar si el error es por duplicado de correo electrónico
            if ($exception->getCode() == 1062) {
                // Redirigir a phpSignUp.php con mensaje de error
                header("Location: /ComparadorPHP/pages/phpSignUp.php?error=Este+correo+electrónico+ya+está+registrado");
                exit;
            }
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al preparar la declaración: " . mysqli_error($conn) . "'
                }).then(() => {
                    window.history.back();
                });
              </script>";
    }

    // Cerrar la conexión
    mysqli_close($conn);
}
?>