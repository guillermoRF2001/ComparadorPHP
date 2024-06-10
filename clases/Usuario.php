<?php

class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->conn;
    }

    public function crearUsuario($email, $password) {
        // Verificar si el correo electrónico ya existe
        $sql = "SELECT idUsuario FROM usuario WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                // El correo electrónico ya está registrado
                $stmt->close();
                return 'duplicate_email';
            }
            $stmt->close();
        }
        
        // Crear el nuevo usuario
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user'; // rol user fijo
        $sql = "INSERT INTO usuario (email, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $email, $hashedPassword, $role);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }
        return false;
    }

    public function obtenerUsuarioPorEmail($email) {
        $sql = "SELECT idUsuario, email, password, role FROM usuario WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $usuario = $result->fetch_assoc();
            $stmt->close();
            return $usuario;
        }
        return null;
    }

    public function obtenerUsuarioPorId($idUsuario) {
        $sql = "SELECT idUsuario, password FROM usuario WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $idUsuario);
            $stmt->execute();
            $result = $stmt->get_result();
            $usuario = $result->fetch_assoc();
            $stmt->close();
            return $usuario;
        }
        return null;
    }

    public function actualizarUsuario($idUsuario, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'user'; // rol user fijo
        $sql = "UPDATE usuario SET email = ?, password = ?, role = ? WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssi", $email, $hashedPassword, $role, $idUsuario);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }
        return false;
    }

    public function eliminarUsuario($idUsuario) {
        $sql = "DELETE FROM usuario WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $idUsuario);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }
        return false;
    }

    public function actualizarPassword($idUsuario, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET password = ? WHERE idUsuario = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $hashedPassword, $idUsuario);
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }
        return false;
    }
}
