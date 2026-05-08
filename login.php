<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Servicios y Soluciones</title>
    <link rel="shortcut icon" href="../images/logo.jpeg">
    <link rel="stylesheet" href="../css/login.css">
    <style>
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="../images/logo.jpeg" alt="Logo" class="login-logo">
            <h2>INICIAR SESIÓN</h2>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">Credenciales incorrectas.</div>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">Registro exitoso. Ahora puedes iniciar sesión.</div>
            <?php endif; ?>

            <form action="../controlador/UsuarioController.php?action=login" method="POST" class="login-form">
                <div class="input-group">
                    <label for="gmail">Correo (Gmail)</label>
                    <input type="email" id="gmail" name="gmail" placeholder="tucorreo@gmail.com" required>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="********" required>
                </div>

                <button type="submit" class="btn-submit">Ingresar</button>
            </form>

            <div class="login-links">
                <p>¿No tienes cuenta? <a href="registro.php" class="link-register">Regístrate aquí</a></p>
                <a href="../index.php" class="link-back">⟵ Volver a Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>
