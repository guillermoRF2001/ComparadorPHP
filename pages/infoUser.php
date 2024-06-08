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

// Obtener el ID del usuario autenticado
$idUsuario = $_SESSION['idUsuario'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];
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


<div class="cuadroInfoUser">
    <h2>Info</h2>
    <!-- Mostrar información del usuario -->
    <h3>id:</h3>
    <p><?php echo $idUsuario; ?></p>
    <h3>Email:</h3>
    <p><?php echo $email; ?></p>
    <h3>Contraseña:</h3>
    <p><?php echo $password; ?></p>
    <button class="botonMod" onclick="location.href='/ComparadorPHP/pages/changePassword.php'"> Cambiar Contraseña </button>
</div>

</body>
</html>