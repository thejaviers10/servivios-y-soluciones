<?php
require_once "conexion.php";

class Usuario {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function registrar($nombre, $telefono, $direccion, $correo, $password) {
        // Verificar si el correo existe
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(":correo", $correo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return false; // El correo ya existe
        }

        // Insertar nuevo usuario
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, telefono, direccion, correo, password) VALUES (:nombre, :telefono, :direccion, :correo, :password)");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":password", $hash_password);
        
        return $stmt->execute();
    }

    public function login($correo, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $stmt->bindParam(":correo", $correo);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }

    public function obtenerTodos() {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $telefono, $direccion, $correo, $rol) {
        $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = :nombre, telefono = :telefono, direccion = :direccion, correo = :correo, rol = :rol WHERE id = :id");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":rol", $rol);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
