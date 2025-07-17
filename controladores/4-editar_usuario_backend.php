<?php

//PHP para editar usuarios
include("../includes/config.php");
session_start();

$id_usuario = $_POST['id_usuario'];
$nombre_usuario = $_POST['nombre_usuario'];
$email = $_POST['email'];
$password_plano = $_POST['password'];
$rol = $_POST['rol'];

if (empty($id_usuario) || empty($nombre_usuario) || empty($email) || empty($rol)) {
  header("Location: ../views/3-crear-usuario.php?error=Faltan%20datos");
  exit();
}

// Si se ingresó una nueva contraseña, la actualizamos, en cada edición 
if (!empty($password_plano)) {
  $password_segura = password_hash($password_plano, PASSWORD_DEFAULT);
  $sql = "UPDATE usuario SET nombre_usuario=?, email=?, password=?, rol=? WHERE id_usuario=?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("ssssi", $nombre_usuario, $email, $password_segura, $rol, $id_usuario);
} else {
  $sql = "UPDATE usuario SET nombre_usuario=?, email=?, rol=? WHERE id_usuario=?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("sssi", $nombre_usuario, $email, $rol, $id_usuario);
}

if ($stmt->execute()) {
  header("Location: ../views/4-ver-usuarios.php?mensaje=Usuario%20actualizado");
} else {
  header("Location: ../views/3-crear-usuario.php?error=Error%20al%20actualizar");
}
?>
