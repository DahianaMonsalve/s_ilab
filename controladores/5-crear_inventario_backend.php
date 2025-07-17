<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../includes/config.php"); //conexión a la base a través del archivo anteriormente configurado
session_start(); 

$nombre_inventario = $_POST['nombre_inventario'];
$fecha_registro = $_POST['fecha_registro'];
$estado_inventario = $_POST['estado_inventario'];

// Validación básica para campos vacíos
if (empty($nombre_inventario) || empty($fecha_registro) || empty($estado_inventario)) {
  header("Location: ../views/5-crear-inventario.php?error=Faltan%20datos");
  exit();
}


//Inserción de datos
$sql = "INSERT INTO inventario (nombre_inventario, fecha_registro, estado_inventario) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $nombre_inventario, $fecha_registro, $estado_inventario);

//Mensajes de creación de usuario o error
if ($stmt->execute()) {
  header("Location: ../views/6-ver-inventario.php?mensaje=Usuario%20creado");
} else {
  header("Location: ../views/5-crear-inventario.php?error=Error%20al%20crear%20usuario");
}
?>
