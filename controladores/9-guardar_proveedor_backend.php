<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../includes/config.php"); //conexión a la base a través del archivo anteriormente configurado
session_start(); 

$nombre_proveedor = $_POST['nombre_proveedor'];
$email_proveedor = $_POST['email_proveedor'];
$contacto_proveedor = $_POST['contacto_proveedor'];
$id_usuario = $_POST['id_usuario'];

// Validación básica para campos vacíos
if (empty($nombre_proveedor) || empty($email_proveedor) || empty($contacto_proveedor)) {
  header("Location: ../views/9-crear-proveedor.php?error=Faltan%20datos");
  exit();
}

//Inserción de datos
$sql = "INSERT INTO proveedor (nombre_proveedor, email_proveedor, contacto_proveedor, id_usuario) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssi", $nombre_proveedor, $email_proveedor, $contacto_proveedor, $id_usuario);

//Mensajes de creación de proveedor o error
if ($stmt->execute()) {
  header("Location: ../views/10-ver-proveedor.php?mensaje=Proveedor%20creado");
} else {
  header("Location: ../views/9-crear-proveedor.php?error=Error%20al%20crear%20proveedor");
}
?>
