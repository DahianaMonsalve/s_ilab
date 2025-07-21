<?php
include("../includes/config.php");
session_start();

$id_proveedor = $_GET['id_proveedor'];

if (!$id_proveedor) {
  header("Location: ../views/10-ver-proveedor.php?error=Proveedor%20no%20válido");
  exit;
}

//Verificar si el proveedor tiene trazabilidad en insumos
$sql_trazabilidad = "
  SELECT COUNT(*) AS total_traza 
  FROM insumo 
  WHERE id_proveedor = ?
";// se comprueba si el proveedor está asociado a insumos ya creados
$stmt_traza = $conexion->prepare($sql_trazabilidad);
$stmt_traza->bind_param("i", $id_proveedor);
$stmt_traza->execute();
$resultado = $stmt_traza->get_result();
$datos = $resultado->fetch_assoc();

//Si tiene trazabilidad, mostrar advertencia de que sólo se puede archivar
if ($datos['total_traza'] > 0) {
  header("Location: ../views/10-ver-proveedor.php?error=El%20proveedor%20tiene%20trazabilidad%20en%20el%20sistema%20(insumos)%20y%20no%20puede%20ser%20eliminado.%20Solo%20puede%20ser%20archivado.");
  exit;
}

//Eliminar proveedor si no tiene registros de insumos
$sql_eliminar = "DELETE FROM proveedor WHERE id_proveedor = ?";
$stmt_eliminar = $conexion->prepare($sql_eliminar);
$stmt_eliminar->bind_param("i", $id_proveedor);

if ($stmt_eliminar->execute()) {
  header("Location: ../views/10-ver-proveedor.php?mensaje=Proveedor%20eliminado%20correctamente");
} else {
  header("Location: ../views/10-ver-proveedor.php?error=No%20se%20pudo%20eliminar%20el%20proveedor");
}
?>

