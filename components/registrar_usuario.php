<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que se han enviado los datos necesarios
    if (isset($_POST["correo"]) && isset($_POST["password"]) && isset($_POST["password2"])) {
        // Validar que las contraseñas coincidan
        if ($_POST["password"] !== $_POST["password2"]) {
            echo "<script>alert('Las contraseñas no coinciden');</script>";
        } else {
            // Conectar a la base de datos
            require_once 'Database.php'; // Asegúrate de que el archivo Database.php tenga la lógica de conexión a la base de datos

            // Crear una instancia de la clase Database y conectar
            $db = new Database();
            $pdo = $db->connect();

            // Crear instancia de la clase Usuario
            require_once 'Usuario.php';

            $usuario = new Usuario($pdo);

            // Obtener los datos del formulario
            $correo = $_POST["correo"];
            $password = $_POST["password"];
            $role = 'user';

            // Insertar usuario
            $usuario->insertarUsuario($correo, $password, $role);
        }
    } else {
        echo "<script>alert('Todos los campos son requeridos');</script>";
    }
}
?>