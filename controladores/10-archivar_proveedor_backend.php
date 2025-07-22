<?php
session_start();
include("../includes/config.php");

$id_proveedor = $_GET['id_proveedor'];

if (!$id_proveedor) {
  header("Location: ../views/10-ver-proveedor.php?error=Proveedor%20no%20válido");
  exit;
}

//Restricción de entrada a la vista según usuario
//------------------------------------------------
if ($_SESSION['rol'] === 'compras') {
  header("Location: ../views/14-acceso-denegado.php");
  exit();
}
//------------------------------------------------

//Validar trazabilidad en el sistema
$sql_trazabilidad = "
  SELECT COUNT(*) AS total_traza 
  FROM insumo 
  WHERE id_proveedor = ?
";
$stmt = $conexion->prepare($sql_trazabilidad);
$stmt->bind_param("i", $id_proveedor);
$stmt->execute();
$resultado = $stmt->get_result();
$data = $resultado->fetch_assoc();

//Si tiene trazabilidad, se puede archivar
if ($data['total_traza'] > 0) {
  $sql_archivar = "UPDATE proveedor SET estado_proveedor = 'archivado' WHERE id_proveedor = ?";
  $stmt_archivar = $conexion->prepare($sql_archivar);
  $stmt_archivar->bind_param("i", $id_proveedor);
  $stmt_archivar->execute();

  header("Location: ../views/10-ver-proveedor.php?mensaje=Proveedor%20archivado%20correctamente.%20Se%20conserva%20la%20trazabilidad.");
  exit;
} else {
  // Si no hay trazabilidad, informar que puede eliminarse
  header("Location: ../views/10-ver-proveedor.php?error=Este%20Proveedor%20no%20tiene%20trazabilidad.%20Puede%20eliminarse.");
  exit;
}
?>
