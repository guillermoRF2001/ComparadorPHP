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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
</head>
<body>
    <header>
        <?php if ($opcion === "opcionNew"): ?>
        <img src="/ComparadorPHP/img/logo.png" alt="logo">
        
            <button onclick="window.location.href='/ComparadorPHP/pages/PHPSignUp.php'" class="button1">Sign Up</button>
            <button onclick="window.location.href='/ComparadorPHP/pages/PHPLogin.php'" class="button2">Login</button>
        <?php elseif ($opcion === "User"): ?>
            <div class="headerIzq">
                <i id="mostrarCaja" class="fa-solid fa-bars"></i>
                <img src="/ComparadorPHP/img/logo.png" onclick="window.location.href='/ComparadorPHP/pages/home.php'" alt="logo">
                <p>COMPU</p>
            </div>
            <div class="headerDer">
                <div class="buscador">
                    <select name="pc" id="selectPC">
                    <option value="" class="hidden-option" selected>Categorías</option>   
                    <option value="portatil">Portatil</option>
                    <option value="Sobremesa">Sobremesa</option>
                    </select>
                    <input type="text" id="search-box" placeholder="">
                </div>
                <button onclick="window.location.href='/ComparadorPHP/components/logOut.php'" class="button4"><i class="fa-regular fa-user"></i></button>
            </div>
            
        <?php elseif ($opcion === "Admin"): ?>
            <div class="headerIzq">
                <i id="mostrarCaja" class="fa-solid fa-bars"></i>
                <img src="/ComparadorPHP/img/logo.png" onclick="window.location.href='/ComparadorPHP/pages/home.php'" alt="logo">
                <p>COMPU</p>
            </div>
            <div class="headerDer">
                <div class="buscador">
                    <select name="pc" id="selectPC">
                    <option value="" class="hidden-option" selected>Categorías</option>   
                    <option value="portatil">Portatil</option>
                    <option value="Sobremesa">Sobremesa</option>
                    </select>
                    <input type="text" id="search-box" placeholder="">
                </div>
                <button onclick="window.location.href='/ComparadorPHP/pages/Editar?.php'" class="button3">Edit</button>
                <button onclick="window.location.href='/ComparadorPHP/components/logOut.php'" class="button4"><i class="fa-regular fa-user"></i></button>
            </div>
        <?php endif; ?>
    </header>




    <?php if ($opcion === "opcionNew"): ?>
    <?php elseif ($opcion === "User" || $opcion === "Admin"): ?>
        <div id="caja" class="rightBox">
            <div class="titulo">
                <img src="/ComparadorPHP/img/logo.png" onclick="window.location.href='/ComparadorPHP/pages/home.php'" alt="logo">
                <p>COMPU</p>
                <i id="closeIcon" class="fa-solid fa-xmark"></i>
            </div>
            <div class="medlinks">
                <div id="fila1" class="fila">
                    <p>Portátiles</p>
                    <i class="fa-solid fa-angle-right"></i>
                </div>
                <div id="info1" class="infoExtra">
                    <p onclick="window.location.href='/ComparadorPHP/pages/Portatiles.php?populares'">Populares</p>
                    <p onclick="window.location.href='/ComparadorPHP/pages/Portatiles.php?populares'">Precio</p>
                </div>
                <div id="fila2" class="fila">
                    <p>Sobremesa</p>
                    <i class="fa-solid fa-angle-right"></i>
                </div>
                <div id="info2" class="infoExtra">
                    <p onclick="window.location.href='/ComparadorPHP/pages/Sobremesa.php?populares'">Populares</p>
                    <p onclick="window.location.href='/ComparadorPHP/pages/Sobremesa.php?populares'">Precio</p>
                </div>
            </div>
        </div>
        <div id="fondo" class="fondoOculto"></div>     
    <?php endif; ?>

    <script src="/ComparadorPHP/scripts/header.js"></script>

</body>
</html>