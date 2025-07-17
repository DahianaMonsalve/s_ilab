<?php
include("../includes/config.php");
session_start();

// Validar que venga el ID
if (!isset($_GET['id_usuario'])) {
  header("Location: ../views/4-ver-usuarios.php?error=ID%20no%20proporcionado");
  exit();
}

$id_usuario = $_GET['id_usuario'];

// Eliminar usuario por ID
$sql = "DELETE FROM usuario WHERE id_usuario=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);

if ($stmt->execute()) {
  header("Location: ../views/4-ver-usuarios.php?mensaje=Usuario%20eliminado%20correctamente");
} else {
  header("Location: ../views/4-ver-usuarios.php?error=No%20se%20pudo%20eliminar%20el%20usuario");
}
?>
