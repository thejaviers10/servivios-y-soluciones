<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../modelo/Usuario.php";
require_once "../modelo/Proyecto.php";
require_once "../modelo/Material.php";

$usuarioModel = new Usuario();
$proyectoModel = new Proyecto();
$materialModel = new Material();

$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$view = $_GET['view'] ?? 'usuarios';

$usuarios = [];
$proyectos = [];
$materiales = [];

if ($isAdmin) {
    $usuarios = $usuarioModel->obtenerTodos();
    if ($view === 'proyectos') {
        $proyectos = $proyectoModel->obtenerTodos();
    } elseif ($view === 'materiales') {
        $materiales = $materialModel->obtenerTodos();
    }
} else {
    // Para usuarios normales, mostrar solo sus proyectos
    if ($view === 'proyectos') {
        $proyectos = $proyectoModel->obtenerPorClienteId($_SESSION['user_id']);
    }
}

// Check for edit modes
$editUser = ($isAdmin && $view === 'usuarios' && isset($_GET['edit_id'])) ? $usuarioModel->obtenerPorId($_GET['edit_id']) : null;
$editProyecto = ($isAdmin && $view === 'proyectos' && isset($_GET['edit_id'])) ? $proyectoModel->obtenerPorId($_GET['edit_id']) : null;
$editMaterial = ($isAdmin && $view === 'materiales' && isset($_GET['edit_id'])) ? $materialModel->obtenerPorId($_GET['edit_id']) : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Servicios y Soluciones</title>
    <link rel="shortcut icon" href="../images/logo.jpeg">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Menú Lateral -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Servicios<span>Y</span>Soluciones</h2>
            </div>
            <ul class="sidebar-menu">
                <li class="<?php echo $view === 'inicio' ? 'active' : ''; ?>"><a href="dashboard.php?view=inicio"><i class="fas fa-home"></i> Inicio</a></li>
                <?php if ($isAdmin): ?>
                    <li class="<?php echo $view === 'usuarios' ? 'active' : ''; ?>"><a href="dashboard.php?view=usuarios"><i class="fas fa-users"></i> Gestión Usuarios</a></li>
                    <li class="<?php echo $view === 'proyectos' ? 'active' : ''; ?>"><a href="dashboard.php?view=proyectos"><i class="fas fa-hard-hat"></i> Proyectos</a></li>
                    <li class="<?php echo $view === 'materiales' ? 'active' : ''; ?>"><a href="dashboard.php?view=materiales"><i class="fas fa-boxes"></i> Materiales</a></li>
                <?php else: ?>
                    <li class="<?php echo $view === 'proyectos' ? 'active' : ''; ?>"><a href="dashboard.php?view=proyectos"><i class="fas fa-hard-hat"></i> Mis Proyectos</a></li>
                <?php endif; ?>
                <li><a href="../index.php"><i class="fas fa-globe"></i> Ver Web</a></li>
                <li><a href="../controlador/UsuarioController.php?action=logout" class="logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            </ul>
        </aside>

        <!-- Contenido Principal -->
        <main class="main-content">
            <!-- Cabecera Top -->
            <header class="top-header">
                <div class="header-title">Panel de Control</div>
                <div class="user-profile">
                    <span>Hola, <b><?php echo htmlspecialchars($_SESSION['user_name']); ?></b> (<?php echo htmlspecialchars($_SESSION['user_role'] ?? 'Usuario'); ?>)</span>
                    <img src="../images/logo.jpeg" alt="Perfil">
                </div>
            </header>

            <!-- Área de Contenido -->
            <div class="content">

                <?php if ($view === 'inicio'): ?>
                    <div class="form-card">
                        <h3>Bienvenido a tu Panel</h3>
                        <?php if ($isAdmin): ?>
                            <p>Desde aquí puedes gestionar los usuarios, proyectos y materiales de Servicios y Soluciones.</p>
                        <?php else: ?>
                            <p>Como cliente, puedes revisar el estado de tus proyectos en la sección "Mis Proyectos".</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($view === 'usuarios' && $isAdmin): ?>
                    <!-- Formulario de Usuarios -->
                    <div class="form-card" id="usuarios">
                        <h3><i class="fas fa-user-<?php echo $editUser ? 'edit' : 'plus'; ?>"></i> <?php echo $editUser ? 'Editar Usuario' : 'Registrar Nuevo Usuario'; ?></h3>
                        <form id="formUsuario" action="../controlador/UsuarioController.php?action=<?php echo $editUser ? 'update' : 'create'; ?>" method="POST">
                            <?php if ($editUser): ?>
                                <input type="hidden" name="id" value="<?php echo $editUser['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="input-row">
                                <input type="text" name="nombre" placeholder="Nombre Completo" value="<?php echo $editUser ? htmlspecialchars($editUser['nombre']) : ''; ?>" required>
                                <input type="text" name="telefono" placeholder="Teléfono" value="<?php echo $editUser ? htmlspecialchars($editUser['telefono']) : ''; ?>" required>
                                <input type="text" name="direccion" placeholder="Dirección / Obra" value="<?php echo $editUser ? htmlspecialchars($editUser['direccion']) : ''; ?>" required>
                            </div>
                            <div class="input-row">
                                <input type="email" name="correo" placeholder="Correo Electrónico" value="<?php echo $editUser ? htmlspecialchars($editUser['correo']) : ''; ?>" required>
                                <?php if (!$editUser): ?>
                                    <input type="password" name="password" placeholder="Contraseña" required>
                                <?php endif; ?>
                                <select name="rol" style="flex: 1; padding: 12px 15px; border: 1px solid #ddd; border-radius: 10px; outline: none; font-size: 14px;">
                                    <option value="usuario" <?php echo ($editUser && $editUser['rol'] == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                                    <option value="admin" <?php echo ($editUser && $editUser['rol'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-guardar"><?php echo $editUser ? 'Actualizar Usuario' : 'Guardar Usuario'; ?></button>
                            <?php if ($editUser): ?>
                                <a href="dashboard.php?view=usuarios" style="margin-left: 10px; color: #143084; text-decoration: none;">Cancelar</a>
                            <?php endif; ?>
                        </form>
                    </div>

                    <!-- Tabla Usuarios -->
                    <div class="table-card">
                        <h3><i class="fas fa-list"></i> Lista de Usuarios y Clientes</h3>
                        <div class="table-responsive">
                            <table id="tablaUsuarios">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Contacto</th>
                                        <th>Dirección/Obra</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $u): ?>
                                        <tr>
                                            <td><?php echo $u['id']; ?></td>
                                            <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                                            <td>
                                                <?php echo htmlspecialchars($u['telefono']); ?><br>
                                                <small style="color: #666;"><?php echo htmlspecialchars($u['correo']); ?></small>
                                            </td>
                                            <td><?php echo htmlspecialchars($u['direccion']); ?></td>
                                            <td><span class="badge"><?php echo htmlspecialchars($u['rol']); ?></span></td>
                                            <td>
                                                <a href="dashboard.php?view=usuarios&edit_id=<?php echo $u['id']; ?>" class="btn-edit" style="color: #143084; margin-right: 10px;"><i class="fas fa-edit"></i></a>
                                                <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                                    <a href="../controlador/UsuarioController.php?action=delete&id=<?php echo $u['id']; ?>" class="btn-delete" onclick="return confirm('¿Eliminar usuario?');"><i class="fas fa-trash"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if ($view === 'proyectos'): ?>
                    <?php if ($isAdmin): ?>
                    <!-- Formulario de Proyectos -->
                    <div class="form-card" id="proyectos">
                        <h3><i class="fas fa-hard-hat"></i> <?php echo $editProyecto ? 'Editar Proyecto' : 'Nuevo Proyecto'; ?></h3>
                        <form id="formProyecto" action="../controlador/ProyectoController.php?action=<?php echo $editProyecto ? 'update' : 'create'; ?>" method="POST">
                            <?php if ($editProyecto): ?>
                                <input type="hidden" name="id" value="<?php echo $editProyecto['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="input-row">
                                <input type="text" name="nombre" placeholder="Nombre del Proyecto" value="<?php echo $editProyecto ? htmlspecialchars($editProyecto['nombre']) : ''; ?>" required>
                                
                                <select name="cliente_id" style="flex: 1; padding: 12px 15px; border: 1px solid #ddd; border-radius: 10px; outline: none; font-size: 14px;">
                                    <option value="">Seleccione un Cliente...</option>
                                    <?php foreach ($usuarios as $u): ?>
                                        <option value="<?php echo $u['id']; ?>" <?php echo ($editProyecto && $editProyecto['cliente_id'] == $u['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($u['nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <select name="estado" style="flex: 1; padding: 12px 15px; border: 1px solid #ddd; border-radius: 10px; outline: none; font-size: 14px;">
                                    <option value="Pendiente" <?php echo ($editProyecto && $editProyecto['estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="En progreso" <?php echo ($editProyecto && $editProyecto['estado'] == 'En progreso') ? 'selected' : ''; ?>>En progreso</option>
                                    <option value="Completado" <?php echo ($editProyecto && $editProyecto['estado'] == 'Completado') ? 'selected' : ''; ?>>Completado</option>
                                </select>
                            </div>
                            <div class="input-row">
                                <input type="date" name="fecha_inicio" title="Fecha Inicio" value="<?php echo $editProyecto ? $editProyecto['fecha_inicio'] : ''; ?>">
                                <input type="date" name="fecha_fin" title="Fecha Fin" value="<?php echo $editProyecto ? $editProyecto['fecha_fin'] : ''; ?>">
                            </div>
                            <button type="submit" class="btn-guardar"><?php echo $editProyecto ? 'Actualizar Proyecto' : 'Guardar Proyecto'; ?></button>
                            <?php if ($editProyecto): ?>
                                <a href="dashboard.php?view=proyectos" style="margin-left: 10px; color: #143084; text-decoration: none;">Cancelar</a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <?php endif; ?>

                    <!-- Tabla Proyectos -->
                    <div class="table-card">
                        <h3><i class="fas fa-list"></i> <?php echo $isAdmin ? 'Lista de Proyectos' : 'Mis Proyectos'; ?></h3>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <?php if ($isAdmin): ?><th>Acciones</th><?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($proyectos as $p): ?>
                                        <tr>
                                            <td><?php echo $p['id']; ?></td>
                                            <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($p['cliente_nombre'] ?? 'Sin Asignar'); ?></td>
                                            <td><span class="badge"><?php echo htmlspecialchars($p['estado']); ?></span></td>
                                            <td><?php echo htmlspecialchars($p['fecha_inicio'] ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($p['fecha_fin'] ?? '-'); ?></td>
                                            <?php if ($isAdmin): ?>
                                            <td>
                                                <a href="dashboard.php?view=proyectos&edit_id=<?php echo $p['id']; ?>" class="btn-edit" style="color: #143084; margin-right: 10px;"><i class="fas fa-edit"></i></a>
                                                <a href="../controlador/ProyectoController.php?action=delete&id=<?php echo $p['id']; ?>" class="btn-delete" onclick="return confirm('¿Eliminar proyecto?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if ($view === 'materiales' && $isAdmin): ?>
                    <!-- Formulario de Materiales -->
                    <div class="form-card" id="materiales">
                        <h3><i class="fas fa-box"></i> <?php echo $editMaterial ? 'Editar Material' : 'Nuevo Material'; ?></h3>
                        <form id="formMaterial" action="../controlador/MaterialController.php?action=<?php echo $editMaterial ? 'update' : 'create'; ?>" method="POST">
                            <?php if ($editMaterial): ?>
                                <input type="hidden" name="id" value="<?php echo $editMaterial['id']; ?>">
                            <?php endif; ?>
                            
                            <div class="input-row">
                                <input type="text" name="nombre" placeholder="Nombre del Material" value="<?php echo $editMaterial ? htmlspecialchars($editMaterial['nombre']) : ''; ?>" required>
                                <input type="number" name="cantidad" placeholder="Cantidad" value="<?php echo $editMaterial ? $editMaterial['cantidad'] : ''; ?>" required>
                                <input type="number" step="0.01" name="precio_unitario" placeholder="Precio Unitario" value="<?php echo $editMaterial ? $editMaterial['precio_unitario'] : ''; ?>" required>
                            </div>
                            <div class="input-row">
                                <input type="text" name="proveedor" placeholder="Proveedor" value="<?php echo $editMaterial ? htmlspecialchars($editMaterial['proveedor']) : ''; ?>">
                                <input type="text" name="descripcion" placeholder="Descripción" value="<?php echo $editMaterial ? htmlspecialchars($editMaterial['descripcion']) : ''; ?>" style="flex: 2;">
                            </div>
                            <button type="submit" class="btn-guardar"><?php echo $editMaterial ? 'Actualizar Material' : 'Guardar Material'; ?></button>
                            <?php if ($editMaterial): ?>
                                <a href="dashboard.php?view=materiales" style="margin-left: 10px; color: #143084; text-decoration: none;">Cancelar</a>
                            <?php endif; ?>
                        </form>
                    </div>

                    <!-- Tabla Materiales -->
                    <div class="table-card">
                        <h3><i class="fas fa-list"></i> Inventario de Materiales</h3>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Precio Ud.</th>
                                        <th>Proveedor</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materiales as $m): ?>
                                        <tr>
                                            <td><?php echo $m['id']; ?></td>
                                            <td><?php echo htmlspecialchars($m['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($m['descripcion']); ?></td>
                                            <td><span class="badge"><?php echo htmlspecialchars($m['cantidad']); ?></span></td>
                                            <td>$<?php echo htmlspecialchars($m['precio_unitario']); ?></td>
                                            <td><?php echo htmlspecialchars($m['proveedor']); ?></td>
                                            <td>
                                                <a href="dashboard.php?view=materiales&edit_id=<?php echo $m['id']; ?>" class="btn-edit" style="color: #143084; margin-right: 10px;"><i class="fas fa-edit"></i></a>
                                                <a href="../controlador/MaterialController.php?action=delete&id=<?php echo $m['id']; ?>" class="btn-delete" onclick="return confirm('¿Eliminar material?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </main>
    </div>
</body>
</html>
