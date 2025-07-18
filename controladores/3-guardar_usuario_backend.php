<?php
// Funcionamiento de creación de usuario
include("../includes/config.php"); //conexión a la base a través del archivo anteriormente configurado
session_start(); 

$nombre_usuario = $_POST['nombre_usuario'];
$email = $_POST['email'];
$password_plano = $_POST['password'];
$rol = $_POST['rol'];

// Validación básica para campos vacíos
if (empty($nombre_usuario) || empty($email) || empty($password_plano) || empty($rol)) {
  header("Location: ../views/3-crear-usuario.php?error=Faltan%20datos");
  exit();
}

//Encriptación de contraseña
$password_segura = password_hash($password_plano, PASSWORD_DEFAULT);

//Inserción de datos
$sql = "INSERT INTO usuario (nombre_usuario, email, password, rol) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssss", $nombre_usuario, $email, $password_segura, $rol);

//Mensajes de creación de usuario o error
if ($stmt->execute()) {
  header("Location: ../views/4-ver-usuarios.php?mensaje=Usuario%20creado");
} else {
  header("Location: ../views/3-crear-usuario.php?error=Error%20al%20crear%20usuario");
}
?>
