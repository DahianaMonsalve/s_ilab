<!--Creación de insumo-->

<!--Código PHP para mensajes o error-->
<?php

if (isset($_GET['error'])) {
  echo "<p style='color:red;'>".$_GET['error']."</p>";
}
if (isset($_GET['mensaje'])) {
  echo "<p style='color:green;'>".$_GET['mensaje']."</p>";
}
?>

<!-- Para reutilizar esta vista en edición de insumo-->
<?php
include("../includes/config.php");
session_start();

$modo = "crear"; //por defecto

if (isset($_GET['id_insumo'])) {
  $modo = "editar";
  $id_insumo = $_GET['id_insumo'];

  $sql = "SELECT nombre_insumo, descripcion, cantidad, stock_minimo, fecha_vencimiento, lote, cas, marca, estado_insumo, id_inventario, fecha_registro_insumo, id_usuario, id_proveedor 
  FROM insumo 
  WHERE id_insumo=?";

  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("i", $id_insumo);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($nombre_insumo, $descripcion, $cantidad, $stock_minimo, $fecha_vencimiento, $lote, $cas, $marca, $estado_insumo, $id_inventario, $fecha_registro_insumo, $id_usuario, $id_proveedor);
    $stmt->fetch();
  } else {
    header("Location: 8-ver-insumos.php?error=Insumo%20no%20encontrado");
    exit();
  }
} else {
  $nombre_insumo = $descripcion = $cantidad = $stock_minimo = $fecha_vencimiento = $lote = $cas = $marca = $estado_insumo = $id_inventario =  $fecha_registro_insumo = "";
}
?>

<!--Código en HTML-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear insumo - Supplies iLab</title>
  <link rel="stylesheet" href="../css/7-crear-insumo.css">
</head>
<body>
  <h2><?php echo ($modo == "editar") ? "✏️ Editar insumo" : "➕ Crear nuevo insumo"; ?></h2>

  <form action="../controladores/<?php echo ($modo == "editar") ? '8-editar_insumo_backend.php' : '7-guardar_insumo_backend.php'; ?>" method="POST" class="formulario"> 
  <?php if ($modo == "editar") { ?>
  <input type="hidden" name="id_insumo" value="<?php echo $id_insumo; ?>">
  <?php } ?>

    <label for="nombre_insumo">Nombre del insumo:</label>
    <input type="text" id="nombre_insumo" name="nombre_insumo" maxlength="150" value="<?php echo htmlspecialchars($nombre_insumo); ?>" required>

    <label for="descripcion">Descripción:</label>
    <input type="text" id="descripcion" name="descripcion" maxlength="400" value="<?php echo htmlspecialchars($descripcion); ?>">

    <label for="cantidad">Cantidad de envases:</label>
    <input type="number" id="cantidad" name="cantidad" step="1" value="<?php echo htmlspecialchars($cantidad); ?>" required>

    <label for="stock_minimo">Stock mínimo:</label>
    <input type="number" id="stock_minimo" name="stock_minimo" step="1" value="<?php echo htmlspecialchars($stock_minimo); ?>"required>

    <label for="fecha_vencimiento">Fecha de vencimiento</label>
    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo htmlspecialchars($fecha_vencimiento); ?>" required>

    <label for="lote">Lote del insumo:</label>
    <input type="text" id="lote" name="lote" maxlength="25" value="<?php echo htmlspecialchars($lote); ?>" required>

    <label for="cas">CAS del insumo:</label>
    <input type="text" id="cas" name="cas" maxlength="25" value="<?php echo htmlspecialchars($cas); ?>">

    <label for="marca">Marca del insumo:</label>
    <input type="text" id="marca" name="marca" maxlength="25" value="<?php echo htmlspecialchars($marca); ?>" required>

    <label for="estado_insumo">Estado del insumo</label>
    <select id="estado_insumo" name="estado_insumo" value="<?php echo htmlspecialchars($estado_insumo); ?>" required>
      <option option value="insumo_sellado" <?= ($estado_insumo == "insumo_sellado") ? 'selected' : '' ?>>Sellado</option>
      <option value="insumo_abierto" <?= ($estado_insumo == "insumo_abierto") ? 'selected' : '' ?>>Abierto</option>
      <option value="insumo_terminado" <?= ($estado_insumo == "insumo_terminado") ? 'selected' : '' ?>>Terminado</option>
    </select>

    <label for="id_proveedor">Proveedor:</label>
    <select id="id_proveedor" name="id_proveedor" required>
      <option value="">-- Selecciona un proveedor --</option>
      <?php
        $sql = "SELECT id_proveedor, nombre_proveedor FROM proveedor";
        $resultado = $conexion->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
          $selected = ($fila['id_proveedor'] == $id_proveedor) ? 'selected' : '';
          echo "<option value='".$fila['id_proveedor']."' $selected>".$fila['nombre_proveedor']."</option>";
        }
      ?>
    </select>


    <label for="id_inventario">Tipo de inventario al que pertenece:</label>
    <select id="id_inventario" name="id_inventario" required>
      <option value="">-- Selecciona un inventario --</option>
      <?php
        $sql = "SELECT id_inventario, nombre_inventario FROM inventario";
        $resultado = $conexion->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
          $selected = ($fila['id_inventario'] == $id_inventario) ? 'selected' : '';
          echo "<option value='".$fila['id_inventario']."' $selected>".$fila['nombre_inventario']."</option>";
        }
      ?>
    </select>


    <label for="fecha_registro_insumo">Fecha de registro</label>
    <input type="date" id="fecha_registro_insumo" name="fecha_registro_insumo" value="<?php echo htmlspecialchars($fecha_registro_insumo); ?>" required>

   <button type="submit">Guardar insumo</button>
    <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>"> <!--Para generar trazabilidad-->
  </form>
</body>
</html>
