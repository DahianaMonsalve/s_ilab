<?php
include("../includes/config.php");
session_start();

$nombre_inventario = $_POST['nombre_inventario'];
$fecha_registro = $_POST['fecha_registro'];
$estado_inventario = $_POST['estado_inventario'];
$id_usuario = $_POST['id_usuario'];

if (empty($nombre_inventario) || empty($fecha_registro) || empty($estado_inventario)) {
  header("Location: ../views/5-crear-inventario.php?error=Faltan%20datos");
  exit();
}

$sql = "INSERT INTO inventario (nombre_inventario, fecha_registro, estado_inventario, id_usuario) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssi", $nombre_inventario, $fecha_registro, $estado_inventario, $id_usuario);

if ($stmt->execute()) {
  header("Location: ../views/6-ver-inventarios.php?mensaje=Inventario%20creado");
} else {
  header("Location: ../views/5-crear-inventario.php?error=Error%20al%20crear%20inventario");
}
?>
