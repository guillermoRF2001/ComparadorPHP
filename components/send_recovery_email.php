<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos el correo electrónico del formulario
    $email = $_POST["email"];

    // Configuramos los detalles del correo electrónico
    $to = $email;
    $subject = "Recuperación de contraseña";
    $message = "Aquí está tu enlace para restablecer la contraseña: pendejo";
    $headers = "From: empresafalsa29@gmail.com";

    // Enviamos el correo electrónico
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(array("success" => true, "message" => "Email sent successfully"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error sending email"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Method not allowed"));
}

// Define el mensaje que deseas imprimir en la consola del navegador
$mensaje = ;

// Genera un script JavaScript que imprimirá el mensaje en la consola del navegador
echo "<script>console.log('" . $mensaje . "');</script>";
?>