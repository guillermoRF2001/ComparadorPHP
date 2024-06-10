<?php
include '../components/BDconfig.php';

session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['idUsuario']) || $_SESSION['role'] !== 'admin') {
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}


// Obtener datos del formulario
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
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
if ($id <= 0 || empty($nombre) || empty($procesador) || empty($ram) || empty($espacio) || empty($grafica) || $precio <= 0 || $puntuacion < 0) {
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

    $allowTypes = array('image/jpeg', 'image/png', 'image/gif');
    if (in_array($fileType, $allowTypes)) {
        // Leer el contenido del archivo
        $imgContent =  file_get_contents($fileTmpName);
        if($fileType=='image/jpeg'){
            $imgtext = 'data:image/jpeg;base64,'.base64_encode($imgContent);
        }elseif($fileType=='image/png'){
            $imgtext = 'data:image/png;base64,'.base64_encode($imgContent);
        }else{
            $imgtext = 'data:image/gif;base64,'.base64_encode($imgContent);
        }
        // Actualizar el contenido de la imagen en la base de datos
        if ($categoria === 'portatil') {
            $result = mysqli_query($conn, "UPDATE portatil SET imgtext = '$imgtext' WHERE id = $id");
        } elseif ($categoria === 'Sobremesa') {
            $result = mysqli_query($conn, "UPDATE Sobremesa SET imgtext = '$imgtext' WHERE id = $id");
        } else {
            echo "Categoría no válida.";
            exit;
        }

        if ($result) {
            $status = 'success';
            echo "Archivo subido correctamente.";
        } else {
            echo "Error al subir el archivo, por favor intenta de nuevo.";
        }
    } else {
        echo 'Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF para subir.';
    }
} else {
    echo 'Por favor selecciona un archivo de imagen para subir.';
}

// Preparar la consulta de actualización
if ($categoria === 'portatil') {
    $stmt = $conn->prepare("UPDATE portatil SET nombre=?, procesador=?, Ram=?, Espacio=?, grafica=?, pantalla_pulgadas=?, precio=?, puntuacion=? WHERE id=?");
    $stmt->bind_param("ssssssdii", $nombre, $procesador, $ram, $espacio, $grafica, $pantalla_pulgadas, $precio, $puntuacion, $id);
} elseif ($categoria === 'Sobremesa') {
    $stmt = $conn->prepare("UPDATE Sobremesa SET nombre=?, procesador=?, Ram=?, Espacio=?, grafica=?, precio=?, puntuacion=? WHERE id=?");
    $stmt->bind_param("sssssdii", $nombre, $procesador, $ram, $espacio, $grafica, $precio, $puntuacion, $id);
} else {
    echo "Categoría no válida.";
    exit;
}

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Datos actualizados correctamente.";
    header("Location: /ComparadorPHP/pages/detalle.php?id=$id&categoria=$categoria");
    exit;
} else {
    echo "Error al actualizar los datos: " . $stmt->error;
}


$stmt->close();
$conn->close();
