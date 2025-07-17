<?php
include("../includes/config.php");
session_start();

// Validar que venga el ID
if (!isset($_GET['id_proveedor'])) {
  header("Location: ../views/10-ver-proveedor.php?error=ID%20no%20proporcionado");
  exit();
}

$id_proveedor = $_GET['id_proveedor'];

// Eliminar usuario por ID
$sql = "DELETE FROM proveedor WHERE id_proveedor=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_proveedor);

if ($stmt->execute()) {
  header("Location: ../views/10-ver-proveedor.php?mensaje=Proveedor%20eliminado%20correctamente");
} else {
  header("Location: ../views/9-ver-proveedors.php?error=No%20se%20pudo%20eliminar%20el%20proveedor");
}
?>
