<?php
session_start();
include("../includes/config.php");

$id_inventario = $_GET['id_inventario'];

if (!$id_inventario) {
  header("Location: ../views/6-ver-inventarios.php?error=Inventario%20no%20válido");
  exit;
}

//Validar trazabilidad en el sistema
$sql_trazabilidad = "
  SELECT COUNT(*) AS total_traza 
  FROM insumo 
  WHERE id_inventario = ?
"; //
$stmt = $conexion->prepare($sql_trazabilidad);
$stmt->bind_param("i", $id_inventario);
$stmt->execute();
$resultado = $stmt->get_result();
$data = $resultado->fetch_assoc();

//Si tiene trazabilidad, se puede archivar
if ($data['total_traza'] > 0) {
  $sql_archivar = "UPDATE inventario SET estado_inventario = 'archivado' WHERE id_inventario = ?";
  $stmt_archivar = $conexion->prepare($sql_archivar);
  $stmt_archivar->bind_param("i", $id_inventario);
  $stmt_archivar->execute();

  header("Location: ../views/6-ver-inventarios.php?mensaje=Inventario%20archivado%20correctamente.%20Se%20conserva%20la%20trazabilidad.");
  exit;
} else {
  // Si no hay trazabilidad, informar que puede eliminarse
  header("Location: ../views/6-ver-inventarios.php?error=Este%20inventario%20no%20tiene%20trazabilidad.%20Puede%20eliminarse.");
  exit;
}
?>
