<?php
session_start();
include("../includes/config.php");

$id_usuario = $_GET['id_usuario'];

if (!$id_usuario) {
  header("Location: ../views/4-ver-usuarios.php?error=Usuario%20no%20válido");
  exit;
}

//Validar trazabilidad en el sistema
$sql_trazabilidad = "
  SELECT 
    (SELECT COUNT(*) FROM insumo WHERE id_usuario = ?) +
    (SELECT COUNT(*) FROM inventario WHERE id_usuario = ?) +
    (SELECT COUNT(*) FROM proveedor WHERE id_usuario = ?)
  AS total_traza
";
$stmt = $conexion->prepare($sql_trazabilidad);
$stmt->bind_param("iii", $id_usuario, $id_usuario, $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$data = $resultado->fetch_assoc();

//Si tiene trazabilidad, se puede archivar
if ($data['total_traza'] > 0) {
  $sql_archivar = "UPDATE usuario SET estado_usuario = 'archivado' WHERE id_usuario = ?";
  $stmt_archivar = $conexion->prepare($sql_archivar);
  $stmt_archivar->bind_param("i", $id_usuario);
  $stmt_archivar->execute();

  header("Location: ../views/4-ver-usuarios.php?mensaje=Usuario%20archivado%20correctamente.%20Se%20conserva%20la%20trazabilidad.");
  exit;
} else {
  // Si no hay trazabilidad, informar que puede eliminarse
  header("Location: ../views/4-ver-usuarios.php?error=Este%20usuario%20no%20tiene%20trazabilidad.%20Puede%20eliminarse.");
  exit;
}
?>
