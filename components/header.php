<?php
// Obtener el rol del usuario desde la sesión
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

// Definir la opción del header según el rol del usuario
echo "<script>console.log(" . json_encode($role) . ");</script>";
$opcion = 'opcionNew'; // Valor por defecto
if ($role === 'admin') {
    $opcion = 'Admin';
} elseif ($role === 'user') {
    $opcion = 'User';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <img src="/ComparadorPHP/img/logo.png" alt="logo">
        <?php if ($opcion === "opcionNew"): ?>
            <button onclick="window.location.href='/ComparadorPHP/pages/PHPSignUp.php'" class="button1">Sign Up</button>
            <button onclick="window.location.href='/ComparadorPHP/pages/PHPLogin.php'" class="button2">Login</button>
        <?php elseif ($opcion === "User"): ?>
            <input type="text" id="search-box" placeholder="Buscar...">
            <button>Usuario</button>
            <button onclick="window.location.href='/ComparadorPHP/components/logOut.php'" class="button2">LogOut</button>
        <?php elseif ($opcion === "Admin"): ?>
            <input type="text" id="search-box" placeholder="Buscar...">
            <button>Admin</button>
            <button onclick="window.location.href='/ComparadorPHP/components/logOut.php'" class="button2">LogOut</button>
        <?php endif; ?>
    </header>
</body>
</html>