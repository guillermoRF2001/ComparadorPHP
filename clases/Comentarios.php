<?php
include_once 'Database.php';

class Comentarios {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->conn;
    }

    public function insertarComentario($idUsuario, $puntuacion, $opinion) {
        $sql = "INSERT INTO comentarios (idUsuario, puntuacion, opinion) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("iis", $idUsuario, $puntuacion, $opinion);
            if ($stmt->execute()) {
                return true;
            }
            $stmt->close();
        }
        return false;
    }

    public function obtenerComentarios() {
        $sql = "SELECT u.email, c.puntuacion, c.opinion, c.fecha 
                FROM comentarios c 
                INNER JOIN usuario u ON c.idUsuario = u.idUsuario";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $comentarios = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $comentarios;
        }
        return [];
    }
}
?>
