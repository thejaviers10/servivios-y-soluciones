<?php
require_once "conexion.php";

class Proyecto {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function crear($nombre, $cliente_id, $estado, $fecha_inicio, $fecha_fin) {
        $stmt = $this->conn->prepare("INSERT INTO proyectos (nombre, cliente_id, estado, fecha_inicio, fecha_fin) VALUES (:nombre, :cliente_id, :estado, :fecha_inicio, :fecha_fin)");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":cliente_id", $cliente_id);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":fecha_inicio", $fecha_inicio);
        $stmt->bindParam(":fecha_fin", $fecha_fin);
        return $stmt->execute();
    }

    public function obtenerTodos() {
        $stmt = $this->conn->prepare("SELECT p.*, u.nombre as cliente_nombre FROM proyectos p LEFT JOIN usuarios u ON p.cliente_id = u.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM proyectos WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorClienteId($cliente_id) {
        $stmt = $this->conn->prepare("SELECT p.*, u.nombre as cliente_nombre FROM proyectos p LEFT JOIN usuarios u ON p.cliente_id = u.id WHERE p.cliente_id = :cliente_id");
        $stmt->bindParam(":cliente_id", $cliente_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $cliente_id, $estado, $fecha_inicio, $fecha_fin) {
        $stmt = $this->conn->prepare("UPDATE proyectos SET nombre = :nombre, cliente_id = :cliente_id, estado = :estado, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin WHERE id = :id");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":cliente_id", $cliente_id);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":fecha_inicio", $fecha_inicio);
        $stmt->bindParam(":fecha_fin", $fecha_fin);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM proyectos WHERE id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
