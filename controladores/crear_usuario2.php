<?php
include("../includes/config.php");

$usuario = "ronaldo.guao";
$email = "ronal.guoa@silab.com";
$password_plano = "cr7";
$password_segura = password_hash($password_plano, PASSWORD_DEFAULT);
$rol = "Analista insumos";

$sql = "INSERT INTO usuario (nombre_usuario, email, password, rol) VALUES ('$usuario', '$email', '$password_segura', '$rol')";
if ($conexion->query($sql) === TRUE) {
    echo "Usuario creado correctamente.";
} else {
    echo "Error: " . $conexion->error;
}
?>