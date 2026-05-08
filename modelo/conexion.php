<?php
// Datos de conexión usando las variables de Railway
$host = getenv('MYSQLHOST');
$dbname = getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT');

try {
    // La conexión ahora usa las variables dinámicas
    $conexion = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Borra la línea de abajo cuando confirmes que funciona
    // echo "Conexión exitosa"; 
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
