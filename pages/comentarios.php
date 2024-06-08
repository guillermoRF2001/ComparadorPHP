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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
    <script src="/ComparadorPHP/scripts/comentarios.js"></script>
    <title>Compu</title>
</head>
<body>

    <?php include '../components/header.php'?>

    <div class="rectanguloFondo">
          
    
        <div class="cajaPuntuacion">
            
            <h1>Puntuación</h1>

            <div id="form" class="stars">

                <input id="radio1" type="radio" name="estrellas" value="1">
                <label for="radio1">★</label>

                <input id="radio2" type="radio" name="estrellas" value="2">
                <label for="radio2">★</label>

                <input id="radio3" type="radio" name="estrellas" value="3">
                <label for="radio3">★</label>

                <input id="radio4" type="radio" name="estrellas" value="4">
                <label for="radio4">★</label>

                <input id="radio5" type="radio" name="estrellas" value="5">
                <label for="radio5">★</label>

            </div>

        </div>


        <div class="cajaComentario">

            <h1>Comentarios</h1>

            <textarea id="comentario" placeholder="Escribe tu comentario aquí..."></textarea>
            
            <div class="cajaContador">

                <span id="contador">0/1000</span>

            </div>
        
        </div>

        <br>

        <div class=cajaBoton>
                
            <button id="enviar">Enviar</button>

        </div>
        
    </div>


</body>
</html>