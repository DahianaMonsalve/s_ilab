<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../includes/config.php"); //conexión a la base a través del archivo anteriormente configurado
session_start(); 

$id_insumo = $_POST['id_insumo'];
$nombre_insumo = $_POST['nombre_insumo'];
$descripcion = $_POST['descripcion']; //puede estar vacío
$cantidad = $_POST['cantidad'];
$stock_minimo = $_POST['stock_minimo']; //puede estar vacío
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$cas = $_POST['cas']; //puede estar vacío
$marca = $_POST['marca'];
$estado_insumo = $_POST['estado_insumo'];
$id_inventario = $_POST['id_inventario'];
$fecha_registro_insumo = $_POST['fecha_registro_insumo'];
$id_usuario = $_POST['id_usuario'];


// Validación básica para campos vacíos
if (empty($nombre_insumo) || empty($cantidad) || empty($fecha_vencimiento) || empty($marca) || empty($estado_insumo) || empty($id_inventario) || empty($fecha_registro)) {
  header("Location: ../views/7-crear-insumo.php?error=Faltan%20datos");
  exit();
}


//Inserción de datos
$sql = "INSERT INTO insumo (nombre_insumo, descripcion, cantidad, stock_minimo, fecha_vencimiento, cas, marca, estado_insumo, id_inventario, fecha_registro_insumo, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssiissssisi", $nombre_insumo, $descripcion, $cantidad, $stock_minimo, $fecha_vencimiento, $cas, $marca, $estado_insumo, $id_inventario, $fecha_registro_insumo $id_usuario);

//Mensajes de creación de insumo o error
if ($stmt->execute()) {
  header("Location: ../views/8-ver-insumos.php?mensaje=Insumo%20creado");
} else {
  header("Location: ../views/7-crear-insumo.php?error=Error%20al%20crear%20insumo");
}
?>
