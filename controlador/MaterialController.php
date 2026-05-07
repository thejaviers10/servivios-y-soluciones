<?php
require_once "../modelo/Material.php";
session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$materialModel = new Material();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../vista/login.php");
    exit();
}

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin) {
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 0;
            $precio_unitario = $_POST['precio_unitario'] ?? 0;
            $proveedor = $_POST['proveedor'] ?? '';
            
            $materialModel->crear($nombre, $descripcion, $cantidad, $precio_unitario, $proveedor);
            header("Location: ../vista/dashboard.php?view=materiales&msg=created");
            exit();
        }
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin) {
            $id = $_POST['id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $cantidad = $_POST['cantidad'] ?? 0;
            $precio_unitario = $_POST['precio_unitario'] ?? 0;
            $proveedor = $_POST['proveedor'] ?? '';
            
            $materialModel->actualizar($id, $nombre, $descripcion, $cantidad, $precio_unitario, $proveedor);
            header("Location: ../vista/dashboard.php?view=materiales&msg=updated");
            exit();
        }
        break;

    case 'delete':
        if (isset($_GET['id']) && $isAdmin) {
            $id = $_GET['id'];
            $materialModel->eliminar($id);
            header("Location: ../vista/dashboard.php?view=materiales&msg=deleted");
            exit();
        }
        break;
}
?>
