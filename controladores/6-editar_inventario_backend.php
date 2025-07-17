<?php
include("../includes/config.php");
session_start();

$id_inventario = $_POST['id_inventario'];
$nombre_inventario = $_POST['nombre_inventario'];
$fecha_registro = $_POST['fecha_registro'];
$estado_inventario = $_POST['estado_inventario'];
$id_usuario = $_POST['id_usuario'];

if (empty($nombre_inventario) || empty($fecha_registro) || empty($estado_inventario)) {
  header("Location: ../views/5-crear-inventario.php?error=Faltan%20datos");
  exit();
}

$sql = "UPDATE inventario SET nombre_inventario=?, fecha_registro=?, estado_inventario=?, id_usuario=? WHERE id_inventario=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssii", $nombre_inventario, $fecha_registro, $estado_inventario, $id_usuario, $id_inventario);


if ($stmt->execute()) {
  header("Location: ../views/6-ver-inventarios.php?mensaje=Inventario%20actualizado");
} else {
  header("Location: ../views/5-crear-inventario.php?error=Error%20al%20actualizar");
}
?>
