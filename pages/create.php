<?php
include '../components/BDconfig.php';

// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['idUsuario']) || $_SESSION['role'] !== 'admin') {
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

$puntuacion = 0;

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compu</title>
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
</head>
<body>
    <!-- Header -->
    <?php include '../components/header.php'?>

    <!-- Main Content -->
    <div class="containerBody">
        
        <form class="formEdit" action="/ComparadorPHP/components/createMSQL.php" method="POST" enctype="multipart/form-data">
            <div class="editLeft">

                <img class="imgEdit" src="/ComparadorPHP/img/imgNoCarga.jpg" alt="Imagen Actualizada">

                <div class="file-select" id="src-file1" >
                    <input type="file" id="imagen" name="src-file1" aria-label="Archivo">
                </div>
                <div>
                <div class="starsEdit" id="starsEdit">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        $starClass = $i <= $puntuacion ? 'star' : 'star empty';
                        echo '<span class="' . $starClass . '" data-value="' . $i . '">&#9733;</span>';
                    }
                    ?>
                </div>
                <input type="hidden" id="puntuacion" name="puntuacion" value="0">
                </div>
            </div>
            <div class="editRight">
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="" placeholder="" required>
                </div>
                <div>
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                    <option value="Sobremesa" selected>Sobremesa</option>
                        <option value="portatil" >Portátil</option>
                    </select>
                </div>
                <div>
                    <label for="procesador">Procesador:</label>
                    <input type="text" id="procesador" name="procesador" value="" required>
                </div>
                <div>
                    <label for="ram">RAM:</label>
                    <input type="text" id="ram" name="ram" value="" required>
                </div>
                <div>
                    <label for="espacio">Espacio:</label>
                    <input type="text" id="espacio" name="espacio" value="" required>
                </div>
                <div>
                    <label for="grafica">Gráfica:</label>
                    <input type="text" id="grafica" name="grafica" value="" required>
                </div>
                <div id="pantallaContainer">
                    <label for="pantalla">Pantalla (pulgadas):</label>
                    <input type="text" id="pantalla" name="pantalla" value="">
                </div>
                <div>
                    <label for="precio">Precio (€):</label>
                    <input type="number" step="0.01" id="precio" name="precio" value="" required>
                </div>
                <button type="submit">Create</button>
            </div>
        </form>
    </div>

    <script src="/ComparadorPHP/scripts/stars.js"></script>
    <script src="/ComparadorPHP/scripts/createPantalla.js"></script>
</body>
</html>