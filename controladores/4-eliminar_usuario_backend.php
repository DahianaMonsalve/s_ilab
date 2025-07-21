<?php
include("../includes/config.php");
session_start();

$id_usuario = $_GET['id_usuario'];

if (!$id_usuario) {
  header("Location: ../views/4-ver-usuarios.php?error=Usuario%20no%20válido");
  exit;
}

//Verificar si el usuario tiene trazabilidad en insumo, inventario o proveedor
$sql_trazabilidad = "
  SELECT 
    (SELECT COUNT(*) FROM insumo WHERE id_usuario = ?) + 
    (SELECT COUNT(*) FROM inventario WHERE id_usuario = ?) +
    (SELECT COUNT(*) FROM proveedor WHERE id_usuario = ?)
  AS total_traza
"; // se comprueba si hay creación del usuario a eliminar en insumo, inventario o proveedor
$stmt_traza = $conexion->prepare($sql_trazabilidad);
$stmt_traza->bind_param("iii", $id_usuario, $id_usuario, $id_usuario);
$stmt_traza->execute();
$resultado = $stmt_traza->get_result();
$datos = $resultado->fetch_assoc();

//Si tiene trazabilidad, mostrar advertencia de que sólo se puede archivar
if ($datos['total_traza'] > 0) {
  header("Location: ../views/4-ver-usuarios.php?error=El%20usuario%20tiene%20trazabilidad%20en%20el%20sistema%20(insumos,%20inventarios%20o%20proveedores)%20y%20no%20puede%20ser%20eliminado.%20Solo%20puede%20ser%20archivado%20📁.");
  exit;
}

//Eliminar usuario si no tiene registros
$sql_eliminar = "DELETE FROM usuario WHERE id_usuario = ?";
$stmt_eliminar = $conexion->prepare($sql_eliminar);
$stmt_eliminar->bind_param("i", $id_usuario);

if ($stmt_eliminar->execute()) {
  header("Location: ../views/4-ver-usuarios.php?mensaje=Usuario%20eliminado%20correctamente");
} else {
  header("Location: ../views/4-ver-usuarios.php?error=No%20se%20pudo%20eliminar%20el%20usuario");
}
?>
