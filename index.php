<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CONSTRUCCIÓN SERVICIOS Y SOLUCIONES</title>
<link rel="shortcut icon" href="images/logo.jpeg">
<link rel="stylesheet" href="css/styles.css">
</head>

<body>
<header>
<nav>
        <a href="#index">Inicio</a>
        <a href="#servi">Servicios</a>
        <a href="#proye">Proyectos</a>
        <a href="#conta">Contáctenos</a>
        
        <?php if($isLoggedIn): ?>
            <a href="dashboard.php" class="btn-login-nav">Panel (<?php echo $_SESSION['user_name']; ?>)</a>
            <a href="controlador/UsuarioController.php?action=logout" class="btn-login-nav" style="background: #dc3545; border-color: #dc3545;">Cerrar Sesión</a>
        <?php else: ?>
            <a href="login.php" class="btn-login-nav">Iniciar Sesión</a>
        <?php endif; ?>

        <a href="https://wa.me/573011106965" class="whatsapp-float" target="_blank">
            <img src="images/whatsapp png.png" alt="WhatsApp">
        </a>
    </nav>

<div class="banner" id="index">
<img src="images/logo.jpeg" alt="logo">
</div>
</header>

<section class="servicios" id="servi">   
<h1>NUESTROS SERVICIOS</h1>
<div class="contenedor-servicios">
 <div class="card">
 <a href="#remodelacion" class="card">
    <h3>Remodelación</h3>
</a>
<p>
Realizamos remodelaciones de casas, apartamentos y locales comerciales
con materiales de alta calidad y excelentes acabados.
</p>
<img src="images/lo (1).jpeg" alt="">
<img src="images/lo (2).jpeg" alt="">

<a href="#mantenimiento" class="card">
<h3>Mantenimiento</h3>
</a>
<p>
Servicios de mantenimiento preventivo y correctivo para viviendas,
edificios y oficinas.
</p>
<img src="images/man.jpeg" alt="">
<img src="images/man (2).jpeg" alt="">

<a href="#construccion" class="card">
    <h3>Construcción</h3>
</a>
<p>
Construcción de viviendas, obras civiles y proyectos comerciales
adaptados a las necesidades de cada cliente.
</p>
<img src="images/r (1).jpeg" alt="">
<img src="images/r (2).jpeg" alt="">
<img src="images/r3.jpeg" alt="">
<img src="images/r (3).jpeg" alt="">
</div>
</section>

<div>
<section class="proye" id="proye">
<h2>PROYECTOS</h2>
<p>
Hemos desarrollado proyectos residenciales y comerciales que destacan
por su diseño, funcionalidad y cumplimiento en tiempos de entrega.
</p>
<img src="images/pla.jpeg" >
</section>
</div>

<div>
<section class="conta" id="conta">
<h2>CONTÁCTENOS</h2>
<img src="images/WhatsApp Image 2026-03-11 at 7.15.02 PM.jpeg" alt="">
<p>
📞 +57 301 1106965

Si tienes un proyecto en mente, estamos listos para asesorarte
y brindarte una cotización personalizada sin compromiso.
</p>
</div>
</section>
</div>
</body>
</html>
