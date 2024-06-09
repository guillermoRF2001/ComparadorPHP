<?php
class Database {
    private $servername = "bfiehqs1aihym0r07gsk-mysql.services.clever-cloud.com";
    private $database = "bfiehqs1aihym0r07gsk";
    private $username = "udmjfy09zp9qiswj";
    private $password = "CgP5nagvTeoZ4oPbSban";
    public $conn;

    // Constructor para establecer la conexión
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

        // Verificar la conexión
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo "<script>console.log('Connected successfully');</script>";
    }

    // Método para cerrar la conexión
    public function close() {
        $this->conn->close();
    }
}
?>