<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="styles.css">
<body>  
    <header>
        <img src="/ComparadorPHP/img/logo.png" alt="logo">
        <?php if ($opcion === "opcionNew"): ?>
            
            <button onclick="window.location.href='/ComparadorPHP/pages/PHPSignUp.php'" class="button1">Sign Up</button>
            <button onclick="window.location.href='/ComparadorPHP/pages/PHPLogin.php'" class="button2">Login</button>


        <?php elseif ($opcion === "opcion2"): ?>
             <input type="text" id="search-box" placeholder="Buscar...">
            <button>Usuario</button>
        <?php endif; ?>
    </header>
</body>