<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (isset($_SESSION['idUsuario'])) {
    // Si no está autenticado, redirigir a la página de inicio de sesión
    header("Location: /ComparadorPHP/pages/home.php");
    exit;
}

// El usuario no está autenticado, puedes mostrar el contenido
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compu</title>
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
 
</head>
<body>

    <!-- Header -->
    <?php include 'components/header.php'?>

    <div class="InfoGeneral">
        <h1>Encuentra tu ordenador </br>ideal. Sin esfuerzo</h1>
        <p>En un mar de opciones, estamos aquí para</br>
            hacer que la elección sea fácil. Compara</br>
            rápidamente entre una amplia selección de </br>
            ordenadores para encontrar el perfecto para ti.</br>    
        </p>
        <h2>¡Haz que la tecnología trabaje para ti</br> hoy mismo!</h2>
    </div>
    <img src="/ComparadorPHP/img/imgInicio.webp" alt="imagen" class="imgInicio">
</body>
</html>