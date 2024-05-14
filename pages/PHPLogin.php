<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>

<h2>Login</h2>

<form action="login.php" method="post">
    <div>
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Recuérdame</label>
    </div>
    <div>
        <button type="submit">Iniciar Sesión</button>
    </div>
</form>

</body>
</html>  