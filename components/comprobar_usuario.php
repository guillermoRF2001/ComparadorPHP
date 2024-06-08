<?php
// Incluir el archivo de configuración
include './BDconfig.php';


// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $email = $_POST['username'];
    $password = $_POST['password'];

    // Preparar la consulta SQL para seleccionar el usuario por su correo electrónico
    $sql = "SELECT idUsuario, email, password, role FROM usuario WHERE email = ?";

    // Preparar la declaración
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, "s", $email);

        // Ejecutar la declaración
        if (mysqli_stmt_execute($stmt)) {
            // Obtener el resultado de la consulta
            $result = mysqli_stmt_get_result($stmt);

            // Verificar si se encontró un usuario con el correo electrónico dado
            if ($row = mysqli_fetch_assoc($result)) {
                // Verificar si la contraseña coincide
                if (password_verify($password, $row['password'])) {
                    session_start();
                    $_SESSION['idUsuario'] = $row['idUsuario'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['password'] =  $password;
                    header("Location: /ComparadorPHP/pages/home.php");
                    exit;
                } else {
                    // La contraseña no coincide
                    header("Location: /ComparadorPHP/pages/PHPLogin.php?error=email+o+password+incorrectos");
                }
            } else {
                header("Location: /ComparadorPHP/pages/PHPLogin.php?error=email+o+password+incorrectos");
            }
        } else {
            // Error al ejecutar la consulta
            header("Location: /ComparadorPHP/pages/PHPLogin.php?error=error+al+ejecutar+la+consulta+intentelo+mas+tarde");
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