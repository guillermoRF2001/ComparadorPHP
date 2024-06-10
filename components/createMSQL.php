<?php
include '../components/BDconfig.php';

session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['idUsuario']) || $_SESSION['role'] !== 'admin') {
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

// Obtener datos del formulario
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
$nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
$procesador = isset($_POST['procesador']) ? htmlspecialchars($_POST['procesador']) : '';
$ram = isset($_POST['ram']) ? htmlspecialchars($_POST['ram']) : '';
$espacio = isset($_POST['espacio']) ? htmlspecialchars($_POST['espacio']) : '';
$grafica = isset($_POST['grafica']) ? htmlspecialchars($_POST['grafica']) : '';
$pantalla_pulgadas = isset($_POST['pantalla']) ? htmlspecialchars($_POST['pantalla']) : null;
$precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
$puntuacion = isset($_POST['puntuacion']) ? intval($_POST['puntuacion']) : 0;

// Validar datos de entrada
if (empty($nombre) || empty($procesador) || empty($ram) || empty($espacio) || empty($grafica) || $precio <= 0 || $puntuacion < 0) {
    echo "Datos de entrada no válidos.";
    exit;
}

// Manejar la subida de la imagen
if (isset($_FILES['src-file1']) && $_FILES['src-file1']['error'] === UPLOAD_ERR_OK) {
    // Obtener información del archivo
    $fileName = $_FILES['src-file1']['name'];
    $fileTmpName = $_FILES['src-file1']['tmp_name'];
    $fileSize = $_FILES['src-file1']['size'];
    $fileType = $_FILES['src-file1']['type'];
    var_dump($fileType);

    $allowTypes = array('image/jpeg', 'image/png', 'image/gif');
    if (in_array($fileType, $allowTypes)) {
        // Leer el contenido del archivo y escaparlo
        $imgContent = file_get_contents($fileTmpName);
        if($fileType=='image/jpeg'){
            $imgtext = 'data:image/jpeg;base64,'.base64_encode($imgContent);
        }elseif($fileType=='image/png'){
            $imgtext = 'data:image/png;base64,'.base64_encode($imgContent);
        }else{
            $imgtext = 'data:image/gif;base64,'.base64_encode($imgContent);
        }
    } else {
        echo 'Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF para subir.';
        exit;
    }
} else {
    echo 'Ha ocurrido un error al subir el archivo.';
    exit;
}

// Preparar la consulta de inserción
if ($categoria === 'portatil') {
    $stmt = $conn->prepare("INSERT INTO portatil (nombre, procesador, Ram, Espacio, grafica, pantalla_pulgadas, precio, puntuacion, imgtext) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssdss", $nombre, $procesador, $ram, $espacio, $grafica, $pantalla_pulgadas, $precio, $puntuacion, $imgtext);
} elseif ($categoria === 'Sobremesa') {
    $stmt = $conn->prepare("INSERT INTO Sobremesa (nombre, procesador, Ram, Espacio, grafica, precio, puntuacion, imgtext) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssds", $nombre, $procesador, $ram, $espacio, $grafica, $precio, $puntuacion, $imgtext);
} else {
    echo "Categoría no válida.";
    exit;
}


// Ejecutar la consulta
if ($stmt->execute()) {
    $last_id = mysqli_insert_id($conn);
    $_SESSION['msg'] = "succesCreate";
    header("Location: /ComparadorPHP/pages/detalle.php?id=$last_id&categoria=$categoria");
    exit;
} else {
    $_SESSION['msg'] = "invalidCreate";
}

$stmt->close();
$conn->close();
