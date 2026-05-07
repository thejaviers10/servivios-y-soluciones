<?php
require_once "../modelo/Proyecto.php";
session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$proyectoModel = new Proyecto();

// Require admin for everything here for now, or at least logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../vista/login.php");
    exit();
}

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin) {
            $nombre = $_POST['nombre'] ?? '';
            $cliente_id = !empty($_POST['cliente_id']) ? $_POST['cliente_id'] : null;
            $estado = $_POST['estado'] ?? 'Pendiente';
            $fecha_inicio = !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
            $fecha_fin = !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
            
            $proyectoModel->crear($nombre, $cliente_id, $estado, $fecha_inicio, $fecha_fin);
            header("Location: ../vista/dashboard.php?view=proyectos&msg=created");
            exit();
        }
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin) {
            $id = $_POST['id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $cliente_id = !empty($_POST['cliente_id']) ? $_POST['cliente_id'] : null;
            $estado = $_POST['estado'] ?? 'Pendiente';
            $fecha_inicio = !empty($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : null;
            $fecha_fin = !empty($_POST['fecha_fin']) ? $_POST['fecha_fin'] : null;
            
            $proyectoModel->actualizar($id, $nombre, $cliente_id, $estado, $fecha_inicio, $fecha_fin);
            header("Location: ../vista/dashboard.php?view=proyectos&msg=updated");
            exit();
        }
        break;

    case 'delete':
        if (isset($_GET['id']) && $isAdmin) {
            $id = $_GET['id'];
            $proyectoModel->eliminar($id);
            header("Location: ../vista/dashboard.php?view=proyectos&msg=deleted");
            exit();
        }
        break;
}
?>
