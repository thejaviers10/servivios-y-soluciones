<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Servicios y Soluciones</title>
    <link rel="shortcut icon" href="images/logo.jpeg">
    <link rel="stylesheet" href="css/login.css">
    <style>
        .login-box {
            max-width: 450px;
            padding: 30px 40px;
        }
        .login-form {
            gap: 12px;
        }
        .input-group label {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <img src="images/logo.jpeg" alt="Logo" class="logo">
                <h2>Crear Cuenta</h2>
                <p>Únete a nuestra plataforma de servicios</p>
            </div>

            <form action="controlador/UsuarioController.php?action=registrar" method="POST" class="login-form">
                <div class="input-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
                </div>

                <div class="input-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" placeholder="Tu número de contacto" required>
                </div>

                <div class="input-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" placeholder="Tu dirección de residencia" required>
                </div>

                <div class="input-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres" required>
                </div>

                <button type="submit" class="btn-login">Registrarse</button>
            </form>

            <div class="login-footer">
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia Sesión</a></p>
                <a href="index.php" class="back-link">← Volver al inicio</a>
            </div>
        </div>
    </div>
</body>
</html>

