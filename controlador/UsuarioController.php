<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../modelo/Usuario.php";

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$usuarioModel = new Usuario();

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['gmail'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = $usuarioModel->login($correo, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_role'] = $user['rol'];
                
                header("Location: ../vista/dashboard.php");
                exit();
            } else {
                header("Location: ../vista/login.php?error=1");
                exit();
            }
        }
        break;

    case 'logout':
        session_destroy();
        header("Location: ../index.php");
        exit();

    case 'registro':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $correo = $_POST['gmail'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $success = $usuarioModel->registrar($nombre, $telefono, $direccion, $correo, $password);
            
            if ($success) {
                header("Location: ../vista/login.php?success=1");
                exit();
            } else {
                header("Location: ../vista/registro.php?error=1");
                exit();
            }
        }
        break;

    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            $nombre = $_POST['nombre'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';
            $rol = $_POST['rol'] ?? 'usuario';
            
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Reusing registrar for create is fine, but admin can specify role?
            // For now, let's just use raw query here or add createAdmin method.
            // Simplified: we'll add a proper create method to model in future, or just do it here:
            global $usuarioModel;
            $db = (new Conexion())->conectar();
            $stmt = $db->prepare("INSERT INTO usuarios (nombre, telefono, direccion, correo, password, rol) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $telefono, $direccion, $correo, $hash_password, $rol]);
            
            header("Location: ../vista/dashboard.php?msg=created");
            exit();
        }
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            $id = $_POST['id'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $rol = $_POST['rol'] ?? 'usuario';
            
            $usuarioModel->actualizar($id, $nombre, $telefono, $direccion, $correo, $rol);
            
            header("Location: ../vista/dashboard.php?msg=updated");
            exit();
        }
        break;

    case 'delete':
        if (isset($_GET['id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
            $id = $_GET['id'];
            $usuarioModel->eliminar($id);
            header("Location: ../vista/dashboard.php?msg=deleted");
            exit();
        }
        break;
}
?>
