<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../includes/config.php");
session_start();

// Capturar datos del formulario
$id_insumo = $_POST['id_insumo'];
$nombre_insumo = $_POST['nombre_insumo'];
$descripcion = $_POST['descripcion'];
$cantidad = (int) $_POST['cantidad'];
$stock_minimo = (int)$_POST['stock_minimo'];
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

//Validación de vencimiento anterior a la fecha
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$hoy = date('Y-m-d');
if ($fecha_vencimiento < $hoy) {
  header("Location: ../views/7-crear-insumo.php?error=La%20fecha%20de%20vencimiento%20no%20puede%20ser%20anterior%20a%20hoy");
  exit();
}

//Validación de cantidad, no puede ser negativa
if ($cantidad < 0) {
  header("Location: ../views/7-crear-insumo.php?error=La%20cantidad%20no%20puede%20ser%20negativa");
  exit();
}

//Validación de stock mínimo, no puede ser negativa
if ($stock_minimo < 0) {
  header("Location: ../views/7-crear-insumo.php?error=Stock%20mínimo%20no%20puede%20ser%20negativo");
  exit();
}

// Validar si el inventario está archivado
$sql_estado_inv = "SELECT estado_inventario FROM inventario WHERE id_inventario = ?";
$stmt_estado = $conexion->prepare($sql_estado_inv);
$stmt_estado->bind_param("i", $id_inventario);
$stmt_estado->execute();
$resultado_estado = $stmt_estado->get_result();
$estado = $resultado_estado->fetch_assoc();

if ($estado['estado_inventario'] === 'archivado') {
  // Redirigir con advertencia técnica
  header("Location: ../views/7-crear-insumo.php?error=Este%20insumo%20está%20vinculado%20a%20un%20inventario%20archivado.%20No%20se%20puede%20cambiar%20su%20ubicación.");
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
