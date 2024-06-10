<?php
include '../components/BDconfig.php';


session_start();

$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : "";
unset($_SESSION['msg']); // Limpiar el mensaje para futuras solicitudes

// Verificar si el usuario está autenticado
if (!isset($_SESSION['idUsuario'])) {
    // Si no está autenticado, redirigir a la página de inicio de sesión
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

$puntuacion = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <script src="/ComparadorPHP/scripts/comentarios.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Compu</title>
</head>
<body>

    <?php include '../components/header.php'?>
    <form method="POST" action="/ComparadorPHP/components/SubirComentario.php">
    <div class="rectanguloFondo">
        <div class="cajaPuntuacion">
            <h1>Puntuación</h1>
            <div class="starsComent" id="starsComent">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        $starClass = $i <= $puntuacion ? 'star' : 'star empty';
                        echo '<span class="' . $starClass . '" data-value="' . $i . '">&#9733;</span>';
                    }
                    ?>
                </div>
                <input type="hidden" id="puntuacion" name="puntuacion" value="<?php echo $puntuacion; ?>">
                </div>
        <div class="cajaComentario">
            <h1>Comentarios</h1>
            <textarea id="comentario" name="comentario" placeholder="Escribe tu comentario aquí..."></textarea>
            <div class="cajaContador">
                <span id="contador">0/1000</span>
            </div>
        </div>
        <br>
        <div class=cajaBoton>
            <button id="enviar">Enviar</button>
        </div>
    </div>
    </form>
    <?php        
        if ($msg === "correct") {
            echo '<script>Swal.fire("Éxito", "Comentario subido con exito", "success");</script>';
        } elseif ($msg === "invalidCreate") {
            echo '<script>Swal.fire("Error", "Comentario no se ha subido, Intentelo mas tarde", "error");</script>';
        }

    ?>
    <script src="/ComparadorPHP/scripts/starsComent.js"></script>
</body>
</html>