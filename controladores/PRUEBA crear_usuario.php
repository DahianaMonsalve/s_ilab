<!--Script para crear usuario porque no tenía en la base de datos jeje-->
<?php
include("../includes/config.php"); //Conexión con la base de datos

$usuario = "Dahiana.Garcia"; 
$email = "dahianagarcia07@gmail.com";
$password_plano = "12345";
$password_segura = password_hash($password_plano, PASSWORD_DEFAULT);
$rol = "admin";

$sql = "INSERT INTO usuario (nombre_usuario, email, password, rol) VALUES ('$usuario', '$email', '$password_segura', '$rol')";

//Comprobación de creación de usuario 
if ($conexion->query($sql) === TRUE) {
    echo "Usuario creado correctamente.";
} else {
    echo "Error: " . $conexion->error;
}
?>