<?php
require_once "conexion.php";

class Material {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function crear($nombre, $descripcion, $cantidad, $precio_unitario, $proveedor) {
        $stmt = $this->conn->prepare("INSERT INTO materiales (nombre, descripcion, cantidad, precio_unitario, proveedor) VALUES (:nombre, :descripcion, :cantidad, :precio_unitario, :proveedor)");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":cantidad", $cantidad);
        $stmt->bindParam(":precio_unitario", $precio_unitario);
        $stmt->bindParam(":proveedor", $proveedor);
        return $stmt->execute();
    }

    public function obtenerTodos() {
        $stmt = $this->conn->prepare("SELECT * FROM materiales");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM materiales WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $descripcion, $cantidad, $precio_unitario, $proveedor) {
        $stmt = $this->conn->prepare("UPDATE materiales SET nombre = :nombre, descripcion = :descripcion, cantidad = :cantidad, precio_unitario = :precio_unitario, proveedor = :proveedor WHERE id = :id");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":cantidad", $cantidad);
        $stmt->bindParam(":precio_unitario", $precio_unitario);
        $stmt->bindParam(":proveedor", $proveedor);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM materiales WHERE id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
