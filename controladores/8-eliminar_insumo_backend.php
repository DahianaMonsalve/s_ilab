<?php
include("../includes/config.php");
session_start();

//Restricción de entrada a la vista según usuario
//------------------------------------------------
if ($_SESSION['rol'] === 'compras') {
  header("Location: ../views/14-acceso-denegado.php");
  exit();
}
//------------------------------------------------

// Validar que venga el ID
if (!isset($_GET['id_insumo'])) {
  header("Location: ../views/8-ver-insumos.php?error=ID%20no%20proporcionado");
  exit();
}

$id_insumo = $_GET['id_insumo'];

// Eliminar insumo por ID
$sql = "DELETE FROM insumo WHERE id_insumo=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_insumo);

if ($stmt->execute()) {
  header("Location: ../views/8-ver-insumos.php?mensaje=Insumo%20eliminado%20correctamente");
} else {
  header("Location: ../views/8-ver-insumos.php?error=No%20se%20pudo%20eliminar%20el%20insumo");
}
?>
