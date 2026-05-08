<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Servicios y Soluciones</title>
    <link rel="shortcut icon" href="../images/logo.jpeg">
    <link rel="stylesheet" href="../css/login.css">
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="../images/logo.jpeg" alt="Logo" class="login-logo">
            <h2>CREAR CUENTA</h2>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">El correo ya está registrado o hubo un error.</div>
            <?php endif; ?>

            <form action="../controlador/UsuarioController.php?action=registro" method="POST" class="login-form">
                <div class="input-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan Pérez" required>
                </div>

                <div class="input-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" placeholder="Ej: 3010000000" required>
                </div>

                <div class="input-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" placeholder="Residencia / Obra" required>
                </div>

                <div class="input-group">
                    <label for="gmail">Correo (Gmail)</label>
                    <input type="email" id="gmail" name="gmail" placeholder="tucorreo@gmail.com" required>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Crea una contraseña" required>
                </div>

                <button type="submit" class="btn-submit">Registrarse</button>
            </form>

            <div class="login-links">
                <p>¿Ya tienes cuenta? <a href="login.php" class="link-register">Inicia sesión aquí</a></p>
                <a href="../index.php" class="link-back">⟵ Volver a Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>
