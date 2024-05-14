<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>

<h2>Sign Up</h2>

<form action="login.php" method="post">
    <div>
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="fa-solid fa-user-secret; Escribe aquí tu texto" style="font-family: FontAwesome;" required>

    </div>
    <div>
        <button type="submit">Iniciar Sesión</button>
    </div>
</form>

</body>
</html>  