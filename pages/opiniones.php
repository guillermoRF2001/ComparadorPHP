<?php
require '../clases/Database.php';
require '../clases/Comentarios.php';

session_start();

$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : "";
unset($_SESSION['msg']);

if (!isset($_SESSION['idUsuario'])) {
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

$idUsuario = $_SESSION['idUsuario'];

$db = new Database();
$comentarios = new Comentarios($db);
$allComentarios = $comentarios->obtenerComentarios();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Compu</title>
</head>
<body>
<?php include '../components/header.php'?>

<div class="containerBody">
    <?php if (!empty($allComentarios)): ?>
        <?php foreach ($allComentarios as $comentario): ?>
            <div class="comentCard">
                <div class="comInicio">
                    <div class="userEmail"><i class="fa-regular fa-user"></i> <?= $comentario['email'] ?></div>
                    <div class="stars"><?= str_repeat('&#9733;', $comentario['puntuacion']) . str_repeat('&#9734;', 5 - $comentario['puntuacion']) ?></div>
                </div>
                <p><?= $comentario['opinion'] ?></p>
                <div class="comFecha"><i class="fa-regular fa-calendar-days"></i><?= $comentario['fecha'] ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay opiniones registradas.</p>
    <?php endif; ?>
</div>

</body>
</html>