<?php
// Iniciar sesión
session_start();

// Verificar si el usuario está autenticado
if (isset($_SESSION['idUsuario'])) {
    // Si no está autenticado, redirigir a la página de inicio de sesión
    header("Location: /ComparadorPHP/pages/home.php");
    exit;
}

// El usuario no está autenticado, puedes mostrar el contenido
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compu</title>
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
</head>
<body>
<div class="cuadroLog">
    <h2>Login</h2>
    <form id="loginForm" action="/ComparadorPHP/components/comprobar_usuario.php" method="post">
        <div>
            <input type="email" id="username" name="username" placeholder=" Email" autocomplete="off" required>
        </div>
        <div>
            <input type="password" id="password" name="password" placeholder=" Password" required>
        </div>
        <div class="remember">
            <input type="checkbox" id="remember" name="remember"> 
            <label for="remember">Remember me</label>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
        <p><a href="/ComparadorPHP/pages/RecuperrPassword.php">Forgot your password?</a></p>
        <p><a href="/ComparadorPHP/pages/PHPSignUp.php">Dont have an account?</a></p>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
// Verificar si hay un mensaje de error en la URL
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
    // Mostrar el mensaje de error usando JavaScript
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '$error_message'
            });
          </script>";
}
?>
</body>
</html>