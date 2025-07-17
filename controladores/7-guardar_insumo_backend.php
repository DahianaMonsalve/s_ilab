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
$lote = $_POST['lote'];
$cas = $_POST['cas']; //puede estar vacío
$marca = $_POST['marca'];
$estado_insumo = $_POST['estado_insumo'];
$id_inventario = $_POST['id_inventario'];
$fecha_registro_insumo = $_POST['fecha_registro_insumo'];
$id_usuario = $_POST['id_usuario'];
$id_proveedor = $_POST['id_proveedor'];

// Validación básica para campos vacíos
if (empty($nombre_insumo) || empty($cantidad) || empty($fecha_vencimiento) || empty($lote) || empty($marca) || empty($estado_insumo) || empty($id_inventario) || empty($fecha_registro_insumo)) {
  header("Location: ../views/7-crear-insumo.php?error=Faltan%20datos");
  exit();
}

//Validación de vencimiento anterior a la fecha
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$hoy = date('Y-m-d');
if ($fecha_vencimiento < $hoy) {
  header("Location: ../views/7-crear-insumo.php?error=La%20fecha%20de%20vencimiento%20no%20puede%20ser%20anterior%20a%20hoy");
  exit();
}

//Validación de cantidad, no puede ser negativa
$cantidad = $_POST['cantidad'];
if ($cantidad < 0) {
  header("Location: ../views/7-crear-insumo.php?error=La%20cantidad%20no%20puede%20ser%20negativa");
  exit();
}


//Inserción de datos
$sql = "INSERT INTO insumo (
  nombre_insumo, descripcion, cantidad, stock_minimo,
  fecha_vencimiento, lote, cas, marca, estado_insumo,
  id_inventario, fecha_registro_insumo, id_usuario, id_proveedor
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssiisssssisii", 
  $nombre_insumo, $descripcion, $cantidad, $stock_minimo,
  $fecha_vencimiento, $lote, $cas, $marca, $estado_insumo,
  $id_inventario, $fecha_registro_insumo, $id_usuario, $id_proveedor);

//Mensajes de creación de insumo o error
if ($stmt->execute()) {
  header("Location: ../views/8-ver-insumos.php?mensaje=Insumo%20creado");
} else {
  header("Location: ../views/7-crear-insumo.php?error=Error%20al%20crear%20insumo");
}
?>
