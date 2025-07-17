<!--Vista creación de inventario-->

<!--Código PHP para mensajes o error-->
<?php
if (isset($_GET['error'])) {
  echo "<p style='color:red;'>".$_GET['error']."</p>";
}
if (isset($_GET['mensaje'])) {
  echo "<p style='color:green;'>".$_GET['mensaje']."</p>";
}
?>

<!-- Para reutilizar esta vista en edición de inventario-->
<?php
include("../includes/config.php");
session_start();

$modo = "crear"; // por defecto

if (isset($_GET['id_inventario'])) {
  $modo = "editar";
  $id_inventario = $_GET['id_inventario'];

  $sql = "SELECT nombre_inventario, fecha_registro, estado_inventario FROM inventario WHERE id_inventario=?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("i", $id_inventario);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($nombre_inventario, $fecha_registro, $estado_inventario);
    $stmt->fetch();
  } else {
    header("Location: 6-ver-inventario.php?error=Inventario%20no%20encontrado");
    exit();
  }
} else {
  $nombre_inventario = "";
  $fecha_registro = "";
  $estado_inventario = "";
}
?>

<!--Código en HTML-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear inventario - Supplies iLab</title>
  <link rel="stylesheet" href="../css/5-crear-inventario.css">
</head>
<body>
  <h2><?php echo ($modo == "editar") ? "✏️ Editar inventario" : "➕ Crear nuevo inventario"; ?></h2>

  <form action="../controladores/<?php echo ($modo == "editar") ? '6-editar_inventario_backend.php' : '5-guardar_inventario_backend.php'; ?>" class="formulario" method="POST"> 
  <?php if ($modo == "editar") { ?>
  <input type="hidden" name="id_inventario" value="<?php echo $id_inventario; ?>">
  <?php } ?>
 

  <label for="nombre_inventario">Nombre del inventario:</label>
    <input type="text" id="nombre_inventario" name="nombre_inventario" maxlength="150" value="<?php echo htmlspecialchars($nombre_inventario); ?>" required>

    <label for="fecha_registro">Fecha de registro</label>
    <input type="date" id="fecha_registro" name="fecha_registro" value="<?php echo htmlspecialchars($fecha_registro); ?>" required>

    <label for="estado_inventario">Estado del inventario</label>
    <select id="estado_inventario" name="estado_inventario" required>
      <option value="Activo" <?php if ($estado_inventario == "Activo") echo "selected"; ?>>Activo</option>
      <option value="Inactivo" <?php if ($estado_inventario == "Inactivo") echo "selected"; ?>>Inactivo</option>
    </select>

    <button type="submit">Guardar inventario</button>
    <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>"> <!--Para generar trazabilidad-->
  </form>
</body>
</html>
