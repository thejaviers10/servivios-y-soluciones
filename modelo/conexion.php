<?php
class Conexion {
    public function conectar() {
        $host = getenv('MYSQLHOST');
        $user = getenv('MYSQLUSER');
        $pass = getenv('MYSQLPASSWORD');
        $db   = getenv('MYSQLDATABASE');
        $port = getenv('MYSQLPORT');

        try {
            // Railway usa PDO por seguridad, este código se adapta a tu Usuario.php
            $cnx = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $cnx;
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}
?>
