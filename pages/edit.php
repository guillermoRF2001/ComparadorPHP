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
$showDetails = $id > 0 && in_array($categoria, ['portatil', 'Sobremesa']);

// Preparar la consulta para obtener la información del ordenador si se solicitó un ID
if ($showDetails) {
    if ($categoria === 'portatil') {
        $stmt = $conn->prepare("SELECT id, nombre, procesador, Ram, Espacio, grafica, pantalla_pulgadas, precio, imgtext, puntuacion FROM portatil WHERE id = ?");
    } elseif ($categoria === 'Sobremesa') {
        $stmt = $conn->prepare("SELECT id, nombre, procesador, Ram, Espacio, grafica, precio, imgtext, puntuacion FROM Sobremesa WHERE id = ?");
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el ordenador
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nombre = htmlspecialchars($row['nombre']);
        $procesador = htmlspecialchars($row['procesador']);
        $ram = htmlspecialchars($row['Ram']);
        $espacio = htmlspecialchars($row['Espacio']);
        $grafica = htmlspecialchars($row['grafica']);
        if ($categoria === 'portatil') {
            $pantalla_pulgadas = htmlspecialchars($row['pantalla_pulgadas']);
        }
        $precio = htmlspecialchars($row['precio']);
        $puntuacion = intval($row['puntuacion']);
        $imagen = $row['imgtext'];
    } else {
        echo "Ordenador no encontrado.";
        exit;
    }
    $stmt->close();
} else {
    echo "Datos de entrada no válidos.";
    exit;
}

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
        <!-- Formulario de edición -->
        <form class="formEdit" action="/ComparadorPHP/components/update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="categoria" value="<?php echo $categoria; ?>">
            <div class="editLeft">
                <?php
                if (!empty($imagen)) {
                    echo '<img class="imgEdit" src="'.$imagen.'" alt="Imagen Actualizada">';
                } else {
                    echo '<img class="imgEdit" src="/ComparadorPHP/img/imgNoCarga.jpg" alt="Imagen no carga">';
                }
                ?>
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
                <input type="hidden" id="puntuacion" name="puntuacion" value="<?php echo $puntuacion; ?>">
                </div>
            </div>
            <div class="editRight">
                <div>
                    <label for="procesador">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" placeholder=" Nombre" required>
                </div>
                <div>
                    <label for="procesador">Procesador:</label>
                    <input type="text" id="procesador" name="procesador" value="<?php echo $procesador; ?>" required>
                </div>
                <div>
                    <label for="ram">RAM:</label>
                    <input type="text" id="ram" name="ram" value="<?php echo $ram; ?>" required>
                </div>
                <div>
                    <label for="espacio">Espacio:</label>
                    <input type="text" id="espacio" name="espacio" value="<?php echo $espacio; ?>" required>
                </div>
                <div>
                    <label for="grafica">Gráfica:</label>
                    <input type="text" id="grafica" name="grafica" value="<?php echo $grafica; ?>" required>
                </div>
                <?php if ($categoria === 'portatil'): ?>
                    <div>
                        <label for="pantalla">Pantalla (pulgadas):</label>
                        <input type="text" id="pantalla" name="pantalla" value="<?php echo $pantalla_pulgadas; ?>" required>
                    </div>
                <?php endif; ?>
                <div>
                    <label for="precio">Precio (€):</label>
                    <input type="number" step="0.01" id="precio" name="precio" value="<?php echo $precio; ?>" required>
                </div>
                <button type="submit">Guardar cambios</button>
            </div>
        </form>
    </div>

    <script src="/ComparadorPHP/scripts/stars.js"></script>
</body>
</html>