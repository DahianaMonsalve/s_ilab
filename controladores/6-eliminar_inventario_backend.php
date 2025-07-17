<?php
include("../includes/config.php");
session_start();

// Validar que venga el ID
if (!isset($_GET['id_inventario'])) {
  header("Location: ../views/6-ver-inventarios.php?error=ID%20no%20proporcionado");
  exit();
}

$id_inventario = $_GET['id_inventario'];

// Eliminar usuario por ID
$sql = "DELETE FROM inventario WHERE id_inventario=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_inventario);

if ($stmt->execute()) {
  header("Location: ../views/6-ver-inventarios.php?mensaje=Inventario%20eliminado%20correctamente");
} else {
  header("Location: ../views/6-ver-inventarios.php?error=No%20se%20pudo%20eliminar%20el%20inventario");
}
?>
