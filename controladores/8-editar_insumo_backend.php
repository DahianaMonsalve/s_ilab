<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../includes/config.php");
session_start();

// Capturar datos del formulario
$id_insumo = $_POST['id_insumo'];
$nombre_insumo = $_POST['nombre_insumo'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$stock_minimo = $_POST['stock_minimo'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$lote = $_POST['lote'];
$cas = $_POST['cas'];
$marca = $_POST['marca'];
$estado_insumo = $_POST['estado_insumo'];
$id_inventario = $_POST['id_inventario'];
$fecha_registro_insumo = $_POST['fecha_registro_insumo'];
$id_usuario = $_POST['id_usuario'];
$id_proveedor = $_POST['id_proveedor'];

// Validación básica
if (
  empty($id_insumo) || empty($nombre_insumo) || empty($cantidad) ||
  empty($fecha_vencimiento) || empty($lote) || empty($marca) ||
  empty($estado_insumo) || empty($id_inventario) || empty($fecha_registro_insumo) || empty($id_proveedor)
) {
  header("Location: ../views/7-crear-insumo.php?error=Faltan%20datos%20para%20editar");
  exit();
}

// Actualizar datos en la base
$sql = "UPDATE insumo SET nombre_insumo=?, descripcion=?, cantidad=?, stock_minimo=?, fecha_vencimiento=?, lote=?, cas=?, marca=?, estado_insumo=?, id_inventario=?, fecha_registro_insumo=?, id_usuario=?,id_proveedor=? WHERE id_insumo=?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssiisssssisiii",
  $nombre_insumo, $descripcion, $cantidad, $stock_minimo,$fecha_vencimiento, $lote, $cas, $marca, $estado_insumo, $id_inventario, $fecha_registro_insumo, $id_usuario, $id_proveedor, $id_insumo
);

if ($stmt->execute()) {
  header("Location: ../views/8-ver-insumos.php?mensaje=Insumo%20actualizado%20correctamente");
} else {
  header("Location: ../views/7-crear-insumo.php?error=Error%20al%20editar%20el%20insumo");
}
?>
