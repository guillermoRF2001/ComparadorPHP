<?php
require '../clases/Database.php';
require '../clases/Usuario.php';

// Iniciar la base de datos
$db = new Database();
$usuario = new Usuario($db);

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $email = $_POST['username'];
    $password = $_POST['password'];

    // Obtener usuario por email
    $user = $usuario->obtenerUsuarioPorEmail($email);

    if ($user) {
        // Verificar si la contraseña coincide
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['idUsuario'] = $user['idUsuario'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['password'] =  $password;
            header("Location: /ComparadorPHP/pages/home.php");
            exit;
        } else {
            // La contraseña no coincide
            header("Location: /ComparadorPHP/pages/PHPLogin.php?error=email+o+password+incorrectos");
        }
    } else {
        header("Location: /ComparadorPHP/pages/PHPLogin.php?error=email+o+password+incorrectos");
    }

    $db->close();
}
?>