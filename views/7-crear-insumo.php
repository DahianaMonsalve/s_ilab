<!--Creación de insumo-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear insumo - Supplies iLab</title>
  <link rel="stylesheet" href="../css/7-crear-insumo.css">
</head>
<body>
  <h2>➕ Crear nuevo insumo</h2>

  <form action="guardar_insumo.php" method="POST" class="formulario"> <!--conectar con PHP-->
    <label for="nombre_insumo">Nombre del insumo:</label>
    <input type="text" id="nombre_insumo" name="nombre_insumo" maxlength="150" required>

    <label for="descripcion">Descripción:</label>
    <input type="text" id="descripcion" name="descripcion" maxlength="400">

    <label for="cantidad">Cantidad de envases:</label>
    <input type="number" id="cantidad" name="cantidad" step="1" required>

    <label for="stock_minimo">Stock mínimo:</label>
    <input type="number" id="stock_minimo" name="stock_minimo" step="1" required>

    <label for="fecha_vencimiento">Fecha de vencimiento</label>
    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" required>

    <label for="lote">Lote del insumo:</label>
    <input type="text" id="lote" name="lote" maxlength="25" required>

    <label for="cas">CAS del insumo:</label>
    <input type="text" id="cas" name="cas" maxlength="25">

    <label for="marca">Marca del insumo:</label>
    <input type="text" id="marca" name="marca" maxlength="25" required>

    <label for="estado_insumo">Estado del insumo</label>
    <select id="estado_insumo" name="estado_insumo" required>
      <option value="insumo_sellado">Sellado</option>
      <option value="insumo_abierto">Abierto</option>
      <option value="insumo_terminado">Terminado</option>
    </select>

    <label for="id_proveedor">Proveedor:</label>
    <select id="id_proveedor" name="id_proveedor" required>
      <option value="1">Químicos Ltda</option>
      <option value="2">BioLab S.A.</option>
      <option value="3">Reactivos del Oriente</option>
    <!-- conectar con la BD con PHP  -->
    </select>

    <label for="id_inventario">Tipo de inventario al que pertenece:</label>
    <select id="id_inventario" name="id_inventario" required>
      <option value="1">Reactivos</option>
      <option value="2">Material de referencia certificado</option>
      <option value="3">Material de vidrio</option>
    </select>
    <!-- conectar con la BD con PHP -->

    <label for="fecha_registro_insumo">Fecha de registro</label>
    <input type="date" id="fecha_registro_insumo" name="fecha_registro_insumo" required>

   <button type="submit">Guardar insumo</button>
    <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
  </form>
</body>
</html>
