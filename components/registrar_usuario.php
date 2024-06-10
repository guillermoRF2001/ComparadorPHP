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
    $password2 = $_POST['password2'];

    // Verificar que las contraseñas coincidan
    if ($password !== $password2) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        exit;
    }

    // Crear el usuario
    $resultado = $usuario->crearUsuario($email, $password);
    if ($resultado === true) {
        header("Location: /ComparadorPHP/pages/PHPLogin.php");
        exit;
    } elseif ($resultado === 'duplicate_email') {
        header("Location: /ComparadorPHP/pages/phpSignUp.php?error=Este+correo+electrónico+ya+está+registrado");
        exit;
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al crear el usuario'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        exit;
    }
}
?>