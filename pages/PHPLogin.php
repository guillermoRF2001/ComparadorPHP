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
    <form action="login.php" method="post">
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
    <p><a href="">Forgot your password?</a></p>
    <p><a href="/ComparadorPHP/pages/PHPSignUp.php">Dont have an account?</a></p>
</form>
</div>



</body>
</html>  