<?php
$server = "localhost";
$user = "root";
$password = "MySQL123"; 
$dbname = "s_ilab";

$conexion = new mysqli($server, $user, $password, $dbname);

//Verificación de error
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}else {
    echo "Conectado";
}
?>