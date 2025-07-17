<?php
include("../includes/config.php");
session_start();

$id_proveedor = $_POST['id_proveedor'];
$nombre_proveedor = $_POST['nombre_proveedor'];
$email_proveedor = $_POST['email_proveedor'];
$contacto_proveedor = $_POST['contacto_proveedor'];
$id_usuario = $_POST['id_usuario'];

if (empty($nombre_proveedor) || empty($email_proveedor) || empty($contacto_proveedor)) {
  header("Location: ../views/9-crear-proveedor.php?error=Faltan%20datos");
  exit();
}

$sql = "UPDATE proveedor SET nombre_proveedor=?, email_proveedor=?, contacto_proveedor=?, id_usuario=? WHERE id_proveedor=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssii", $nombre_proveedor, $email_proveedor, $contacto_proveedor, $id_usuario, $id_proveedor);


if ($stmt->execute()) {
  header("Location: ../views/10-ver-proveedor.php?mensaje=Proveedor%20actualizado");
} else {
  header("Location: ../views/9-crear-proveedor.php?error=Error%20al%20actualizar%20proveedor");
}
?>
