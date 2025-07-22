<?php
include("../includes/config.php");
session_start();

$id_inventario = $_GET['id_inventario'];

if (!$id_inventario) {
  header("Location: ../views/6-ver-inventarios.php?error=Inventario%20no%20válido");
  exit;
}

//Restricción de entrada a la vista según usuario
//------------------------------------------------
if ($_SESSION['rol'] === 'insumos') {
  header("Location: ../views/14-acceso-denegado.php");
  exit();
}
//------------------------------------------------


//Verificar si el inventario tiene trazabilidad en insumos
$sql_trazabilidad = "
  SELECT COUNT(*) AS total_traza 
  FROM insumo 
  WHERE id_inventario = ?
";// se comprueba si el inventario está asociado a insumos ya creados
$stmt_traza = $conexion->prepare($sql_trazabilidad);
$stmt_traza->bind_param("i", $id_inventario);
$stmt_traza->execute();
$resultado = $stmt_traza->get_result();
$datos = $resultado->fetch_assoc();

//Si tiene trazabilidad, mostrar advertencia de que sólo se puede archivar
if ($datos['total_traza'] > 0) {
  header("Location: ../views/6-ver-inventarios.php?error=El%20inventario%20tiene%20trazabilidad%20en%20el%20sistema%20(insumos)%20y%20no%20puede%20ser%20eliminado.%20Solo%20puede%20ser%20archivado%20📁.");
  exit;
}

//Eliminar inventario si no tiene registros de insumos
$sql_eliminar = "DELETE FROM inventario WHERE id_inventario = ?";
$stmt_eliminar = $conexion->prepare($sql_eliminar);
$stmt_eliminar->bind_param("i", $id_inventario);

if ($stmt_eliminar->execute()) {
  header("Location: ../views/6-ver-inventarios.php?mensaje=Inventario%20eliminado%20correctamente");
} else {
  header("Location: ../views/6-ver-inventarios.php?error=No%20se%20pudo%20eliminar%20el%20inventario");
}
?>
