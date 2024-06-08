<?php
// Incluir el archivo de configuración y establecer la conexión a la base de datos
include '../components/BDconfig.php';

// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    // Si no está autenticado, redirigir a la página de inicio de sesión
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compu</title>
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
</head>
<body>

   <!-- Header -->
   <?php include '../components/header.php'?>

<div class="changePassword">
    <h2>Change </br>Password</h2>
    <form id="signupForm" action="/ComparadorPHP/components/updatePassword.php" method="post">
        <div>
            <input type="password" id="oldPassword" name="oldPassword" placeholder=" Old_Password" required>
        </div>
        <div>
            <input type="password" id="newPassword" name="newPassword" placeholder=" New_password" required>
        </div>
        <div>
            <input type="password" id="password2" name="password2" placeholder=" Repeat_Password" required>
        </div>
        <div>
            <button type="submit">Update</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/ComparadorPHP/scripts/checkPasswordNew.js"></script>
<?php
// Verificar si hay un mensaje de error en la URL
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
    // Mostrar el mensaje de error usando JavaScript
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '$error_message'
            });
          </script>";
}
?>
</body>
</html>