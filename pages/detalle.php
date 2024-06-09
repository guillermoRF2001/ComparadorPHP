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

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';
// Definir la opción del header según el rol del usuario
$opcion = 'opcionNew'; // Valor por defecto
if ($role === 'admin') {
    $opcion = 'Admin';
} elseif ($role === 'user') {
    $opcion = 'User';
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'Detalles de ' . $nombre; ?></title>
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Compu</title>
</head>
<body>

    <!-- Header -->
    <?php include '../components/header.php'?>

    <!-- Main Content -->
    <div class="containerBody">
        <div class="details">
            <div class="infoLeft">
            <img class="imgDetail" src="<?php echo $imagen; ?>" alt="Imagen de <?php echo $nombre; ?>">
                
            <div class="stars">
                    <?php echo str_repeat('&#9733;', $puntuacion) . str_repeat('&#9734;', 5 - $puntuacion); ?>
                </div>
            </div>
            <div class="infoRight">
                <h2><?php echo $nombre; ?></h2>
                <p>Procesador: <?php echo $procesador; ?></p>
                <p>RAM: <?php echo $ram; ?></p>
                <p>Espacio: <?php echo $espacio; ?></p>
                <p>Gráfica: <?php echo $grafica; ?></p>
                <?php if ($categoria === 'portatil'): ?>
                    <p>Pantalla: <?php echo $pantalla_pulgadas; ?> pulgadas</p>
                <?php endif; ?>

                <div class="infoRightBottom">
                <h3>Precio: <?php echo $precio; ?> €</h3>
                <?php if ($opcion === "Admin"): ?>
                    <div>
                    <a href="edit.php?id=<?php echo $id; ?>&categoria=<?php echo $categoria; ?>"><button class="edit">Editar</button></a>
                    <a href="#" onclick="confirmDelete(<?php echo $id; ?>, '<?php echo $categoria; ?>')"><button class="delete">Eliminar</button></a>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="/ComparadorPHP/scripts/confirmDelete.js"></script>
</body>
</html>
