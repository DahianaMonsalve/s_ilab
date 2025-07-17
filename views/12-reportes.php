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
  <h2>📄 Generar reporte de insumos</h2>

  <form action="generar_reporte.php" method="GET" class="formulario_reporte">
    <label for="fecha_inicio">Desde:</label>
    <input type="date" id="fecha_inicio" name="fecha_inicio" required>

    <label for="fecha_fin">Hasta:</label>
    <input type="date" id="fecha_fin" name="fecha_fin" required>

    <label for="inventario">Inventario:</label>
    <select id="id_inventario" name="id_inventario">
      <option value="">Todos</option>
      <option value="1">Reactivos</option>
      <option value="2">Material de referencia</option>
      <option value="3">Material de vidrio</option>
    </select>

    <label for="estado_insumo">Estado:</label>
    <select id="estado_insumo" name="estado_insumo">
      <option value="">Todos</option>
      <option value="sellado">Sellado</option>
      <option value="abierto">Abierto</option>
      <option value="terminado">Terminado</option>
    </select>

    <button type="submit">🔍 Ver resultados</button>
    <button type="submit" formaction="descargar_pdf.php">🧾 Descargar PDF</button>
    <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
  </form>
</body>
</html>
