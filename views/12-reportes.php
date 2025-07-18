<!-- Vista de generación de reportes -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generar reporte - Supplies iLab</title>
  <link rel="stylesheet" href="../css/12-reportes.css">
</head>
<body>
  <?php include("../includes/config.php"); ?> <!--Conexión a la BD para consulta dinámica-->
  <h2>📄 Generar reporte de insumos</h2>

  <form action="13-resultado-reporte.php" method="GET" class="formulario_reporte">
    <label for="fecha_inicio">Desde:</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio" required>

    <label for="fecha_fin">Hasta:</label>
    <input type="date" id="fecha_fin" name="fecha_fin" required>

    <label for="id_inventario">Inventario:</label>
    <select id="id_inventario" name="id_inventario">
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

    <label for="estado_insumo">Estado:</label>
    <select id="estado_insumo" name="estado_insumo">
      <option value="">-- Selecciona un estado del insumo --</option>
      <option value="insumo_sellado">Sellado</option>
      <option value="insumo_abierto">Abierto</option>
      <option value="insumo_terminado">Terminado</option>
    </select>

    <button type="submit">🔍 Ver resultados</button>
    <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
  </form>
</body>
</html>
