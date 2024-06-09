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

if (isset($_GET['id1']) && isset($_GET['categoria1']) && isset($_GET['id2']) && isset($_GET['categoria2'])) {
    $id1 = $_GET['id1'];
    $categoria1 = $_GET['categoria1'];
    $id2 = $_GET['id2'];
    $categoria2 = $_GET['categoria2'];

    // Consultar los detalles del primer ordenador
    if ($categoria1 === 'portatil') {
        $sql1 = "SELECT * FROM portatil WHERE id = $id1";
    } else {
        $sql1 = "SELECT * FROM Sobremesa WHERE id = $id1";
    }

    // Consultar los detalles del segundo ordenador
    if ($categoria2 === 'portatil') {
        $sql2 = "SELECT * FROM portatil WHERE id = $id2";
    } else {
        $sql2 = "SELECT * FROM Sobremesa WHERE id = $id2";
    }

    $result1 = $conn->query($sql1);
    $result2 = $conn->query($sql2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Ordenadores</title>
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
    <script src="/ComparadorPHP/scripts/selectComputer.js"></script>
</head>
<body>
<?php include '../components/header.php'?>

<?php
    if ($result1->num_rows > 0 && $result2->num_rows > 0) {
        $computer1 = $result1->fetch_assoc();
        $computer2 = $result2->fetch_assoc();

        // Function to set background color
        function setBackground($val1, $val2) {
            if ($val1 > $val2) {
                return "background-color: green;";
            } elseif ($val1 < $val2) {
                return "background-color: red;";
            } else {
                return "background-color: yellow;";
            }
        }

        // Function to convert storage to GB
        function convertirEspacioAGB($espacio) {
            if (stripos($espacio, 'TB') !== false) {
                return floatval($espacio) * 1024; // Convertir TB a GB
            } elseif (stripos($espacio, 'GB') !== false) {
                return floatval($espacio); // Dejar en GB
            } else {
                return 0; // Por si acaso no hay unidad especificada
            }
        }

        $precioStyle1 = setBackground($computer1['precio'], $computer2['precio']);
        $precioStyle2 = setBackground($computer2['precio'], $computer1['precio']);

        $puntuacionStyle1 = setBackground($computer1['puntuacion'], $computer2['puntuacion']);
        $puntuacionStyle2 = setBackground($computer2['puntuacion'], $computer1['puntuacion']);

        $ramStyle1 = setBackground($computer1['Ram'], $computer2['Ram']);
        $ramStyle2 = setBackground($computer2['Ram'], $computer1['Ram']);

        // Check if both computers have inches defined
        $pulgadas1 = isset($computer1['pantalla_pulgadas']) ? $computer1['pantalla_pulgadas'] : '';
        $pulgadas2 = isset($computer2['pantalla_pulgadas']) ? $computer2['pantalla_pulgadas'] : '';

        $pulgadasStyle1 = '';
        $pulgadasStyle2 = '';
        if ($pulgadas1 && $pulgadas2) {
            if ($pulgadas1 > $pulgadas2) {
                $pulgadasStyle1 = 'background-color: green;';
                $pulgadasStyle2 = 'background-color: red;';
            } elseif ($pulgadas1 < $pulgadas2) {
                $pulgadasStyle1 = 'background-color: red;';
                $pulgadasStyle2 = 'background-color: green;';
            } else {
                $pulgadasStyle1 = $pulgadasStyle2 = 'background-color: yellow;';
            }
        } elseif (!$pulgadas2) {
            $pulgadasStyle1 = 'background-color: green;';
        } elseif (!$pulgadas1) {
            $pulgadasStyle2 = 'background-color: green;';
        }

        $espacio1 = convertirEspacioAGB($computer1['Espacio']);
        $espacio2 = convertirEspacioAGB($computer2['Espacio']);

        $espacioStyle1 = setBackground($espacio1, $espacio2);
        $espacioStyle2 = setBackground($espacio2, $espacio1);

        // Mostrar los detalles de los dos ordenadores para la comparación
        echo '<div class="comparison">';
        echo '<div class="computer">';
        echo '<h2>'.$computer1['nombre'].'</h2>';
        echo '<img src="'.$computer1['imgtext'].'" alt="Imagen de '.$computer1['nombre'].'" onerror="this.onerror=null; this.src=\'/ComparadorPHP/img/imgNoCarga.jpg\'">';
        echo '<div>';
        echo '<p style="'.$precioStyle1.'">Precio: '.$computer1['precio'].'</p>';
        echo '<p style="'.$puntuacionStyle1.'">Puntuación: '.$computer1['puntuacion'].'</p>';
        echo '<p style="'.$ramStyle1.'">RAM: '.$computer1['Ram'].'</p>';
        if ($categoria1 === 'portatil') {
            echo '<p style="'.$pulgadasStyle1.'">Pulgadas: '.$pulgadas1.'</p>';
        }
        echo '<p>Procesador: '.$computer1['procesador'].'</p>';
        echo '<p style="'.$espacioStyle1.'">Almacenamiento: '.$computer1['Espacio'].'</p>';
        echo '<p>Tarjeta Gráfica: '.$computer1['grafica'].'</p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="computer">';
        echo '<h2>'.$computer2['nombre'].'</h2>';
        echo '<img src="'.$computer2['imgtext'].'" alt="Imagen de '.$computer2['nombre'].'" onerror="this.onerror=null; this.src=\'/ComparadorPHP/img/imgNoCarga.jpg\'">';
        echo '<div>';
        echo '<p style="'.$precioStyle2.'">Precio: '.$computer2['precio'].'</p>';
        echo '<p style="'.$puntuacionStyle2.'">Puntuación: '.$computer2['puntuacion'].'</p>';
        echo '<p style="'.$ramStyle2.'">RAM: '.$computer2['Ram'].'</p>';
        if ($categoria2 === 'portatil') {
            echo '<p style="'.$pulgadasStyle2.'">Pulgadas: '.$pulgadas2.'</p>';
        }
        echo '<p>Procesador: '.$computer2['procesador'].'</p>';
        echo '<p style="'.$espacioStyle2.'">Almacenamiento: '.$computer2['Espacio'].'</p>';
        echo '<p>Tarjeta Gráfica: '.$computer2['grafica'].'</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo "No se encontraron detalles de los ordenadores.";
    }
} else {
    echo "No se han proporcionado los IDs de los ordenadores.";
}

// Close the connection
$conn->close();
?>
</body>
</html>