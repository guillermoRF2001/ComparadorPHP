<?php
require '../clases/Database.php';
require '../clases/Comentarios.php';

session_start();

if (!isset($_SESSION['idUsuario'])) {
    header("Location: /ComparadorPHP/pages/phpLogin.php");
    exit;
}

if (isset($_POST['puntuacion']) && isset($_POST['comentario'])) {
    $puntuacion = $_POST['puntuacion'];
    $opinion = $_POST['comentario'];
    $idUsuario = $_SESSION['idUsuario'];

    $db = new Database();
    $comentarios = new Comentarios($db);

    if ($comentarios->insertarComentario($idUsuario, $puntuacion, $opinion)) {
        $_SESSION['msg'] = "correct";
    } else {
        $_SESSION['msg'] = "invalid";
    }

    $db->close();
    header("Location: /ComparadorPHP/pages/writeComentarios.php");
    exit;
} else {
    $_SESSION['msg'] = "invalid";
    echo "Error: Datos del formulario no recibidos.";
    header("Location: /ComparadorPHP/pages/writeComentarios.php");
    exit;
}
