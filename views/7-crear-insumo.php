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

//Restricción de entrada a la vista según usuario
//------------------------------------------------
if ($_SESSION['rol'] === 'analista_compras') {
  header("Location: acceso_denegado.php");
  exit();
}
//------------------------------------------------

$modo = "crear"; 

//Si viene un id_insumo, entra a modo editar, sino, sale del primer if y crea un nuevo insumo
if (isset($_GET['id_insumo'])) {
  $modo = "editar";
  $id_insumo = $_GET['id_insumo'];

  //Búsqueda del insumo en la BD donde id_insumo=?
  $sql = "SELECT nombre_insumo, descripcion, cantidad, stock_minimo, fecha_vencimiento, lote, cas, marca, estado_insumo, id_inventario, fecha_registro_insumo, id_usuario, id_proveedor 
  FROM insumo 
  WHERE id_insumo=?";

  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("i", $id_insumo); //Parámetro de la búsqueda
  $stmt->execute();
  $stmt->store_result();

  //Obtención de datos de la búsqueda para guardar esos datos y editar sobre ellos, sino encuentra nada redirigé a error
  if ($stmt->num_rows > 0) {
    $stmt->bind_result($nombre_insumo, $descripcion, $cantidad, $stock_minimo, $fecha_vencimiento, $lote, $cas, $marca, $estado_insumo, $id_inventario, $fecha_registro_insumo, $id_usuario, $id_proveedor);
    $stmt->fetch();
    
    //Consulta del proveedor asociado
    $sql_prov = "SELECT estado_proveedor, nombre_proveedor FROM proveedor WHERE id_proveedor = ?";
    $stmt_prov = $conexion->prepare($sql_prov);
    $stmt_prov->bind_param("i", $id_proveedor);
    $stmt_prov->execute();
    $res_prov = $stmt_prov->get_result();
    $datos_prov = $res_prov->fetch_assoc();
    $estado_proveedor = $datos_prov['estado_proveedor'];
    $nombre_proveedor = $datos_prov['nombre_proveedor'];

    //Consulta al inventario asociado al id_insumo
    $sql_estado = "SELECT estado_inventario, nombre_inventario FROM inventario WHERE id_inventario = ?";
    $stmt_estado = $conexion->prepare($sql_estado);
    $stmt_estado->bind_param("i", $id_inventario);
    $stmt_estado->execute();
    $result_estado = $stmt_estado->get_result();
    $datos_inv = $result_estado->fetch_assoc();
    $estado_inventario = $datos_inv['estado_inventario'];
    $nombre_inventario = $datos_inv['nombre_inventario'];
    
  } else {
    header("Location: 8-ver-insumos.php?error=Insumo%20no%20encontrado");
    exit();
  }
} 
else {
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


    <!--Para edición de insumos cuyo proveedor se archivó-->    
    <label for="id_proveedor">Proveedor:</label>
    <?php 
    if ($modo === "editar" && $estado_proveedor === "archivado") { ?>
      <select id="id_proveedor" disabled>
        <option value="<?= $id_proveedor ?>">
          <?= htmlspecialchars($nombre_proveedor) ?> (archivado)
        </option>
      </select>
      <input type="hidden" name="id_proveedor" value="<?= $id_proveedor ?>">
      <p class="msg-info" style="color: #cc0000; font-size: 12px">Este insumo está asociado a un proveedor archivado. No puede cambiarse.</p>
    <?php } 
      else { ?>
        <select id="id_proveedor" name="id_proveedor" required>
          <option value="">-- Selecciona un proveedor --</option>
          <?php
            $sql = "
            SELECT id_proveedor, nombre_proveedor 
            FROM proveedor
            WHERE estado_proveedor = 'activo'
            ";
            $resultado = $conexion->query($sql);
            while ($fila = $resultado->fetch_assoc()) {
              $selected = ($fila['id_proveedor'] == $id_proveedor) ? 'selected' : '';
              echo "<option value='".$fila['id_proveedor']."' $selected>".$fila['nombre_proveedor']."</option>";
            }
          ?>
        </select>
    <?php } ?>


    <!--Para edición de insumos cuyo inventario se archivó-->
    <label for="id_inventario">Tipo de inventario al que pertenece:</label>
    <?php 
    if ($modo === "editar" && $estado_inventario === "archivado") { ?>
      <select id="id_inventario" disabled>
        <option value="<?= $id_inventario ?>">
          <?= htmlspecialchars($nombre_inventario) ?> (archivado)
        </option>
      </select>
      <input type="hidden" name="id_inventario" value="<?= $id_inventario ?>">
      <p class="msg-info" style="color: #cc0000; font-size: 12px">Este insumo está asociado a un inventario archivado. No puede cambiarse.</p>
    <?php } 
    else { ?>
      <select id="id_inventario" name="id_inventario" required>
        <option value="">-- Selecciona un inventario --</option>
        <?php
          $sql = "
          SELECT id_inventario, nombre_inventario
          FROM inventario
          WHERE estado_inventario = 'activo'
          ";
          $resultado = $conexion->query($sql);
          while ($fila = $resultado->fetch_assoc()) {
            $selected = ($fila['id_inventario'] == $id_inventario) ? 'selected' : '';
            echo "<option value='".$fila['id_inventario']."' $selected>".$fila['nombre_inventario']."</option>";
          }
        ?>
      </select>
      <?php 
    } ?>


    <label for="fecha_registro_insumo">Fecha de registro</label>
    <input type="date" id="fecha_registro_insumo" name="fecha_registro_insumo" value="<?php echo htmlspecialchars($fecha_registro_insumo); ?>" required>

   <button type="submit">Guardar insumo</button>
    <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>"> <!--Para generar trazabilidad-->
  </form>
</body>
</html>
