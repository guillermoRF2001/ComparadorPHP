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
    <h2>Recuperate Password</h2>
    <p>Please enter the email address associated with your account, and we'll send you instructions on how to reset your password.</p>
    <form id="CheckEmail"   >
    <div>
        <input type="email" id="username" name="username" placeholder=" Email" autocomplete="off" required>
    </div>
    <div>
        <button type="submit">Send</button>
    </div>
</form>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/ComparadorPHP/scripts/RecoverPassword.js"></script>
</body>
</html>  