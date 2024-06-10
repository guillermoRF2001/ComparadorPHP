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
    if ($usuario->crearUsuario($email, $password)) {
        header("Location: /ComparadorPHP/pages/PHPLogin.php");
        exit;
    } else {
        // Verificar si el error es por duplicado de correo electrónico
        header("Location: /ComparadorPHP/pages/phpSignUp.php?error=Este+correo+electrónico+ya+está+registrado");
        exit;
    }
    

}
