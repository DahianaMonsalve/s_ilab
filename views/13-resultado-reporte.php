<?php
include("../includes/config.php");

$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];
$id_inventario = $_GET['id_inventario'];
$estado_insumo = $_GET['estado_insumo'];

//  Contrucción de la consulta base
$sql = "SELECT insumo.*, inventario.nombre_inventario 
        FROM insumo 
        JOIN inventario ON insumo.id_inventario = inventario.id_inventario 
        WHERE insumo.fecha_registro_insumo BETWEEN ? AND ?";
$parametros = [$fecha_inicio, $fecha_fin];
$tipos = "ss";

function estadoInsumo($estado_insumo) {
  switch ($estado_insumo) {
    case "insumo_sellado": return "Sellado";
    case "insumo_abierto": return "Abierto";
    case "insumo_terminado": return "Terminado";
    default: return "Desconocido";
  }
}

//  Filtramos por si se seleccionó inventario
if (!empty($id_inventario)) {
  $sql .= " AND insumo.id_inventario = ?";
  $parametros[] = $id_inventario;
  $tipos .= "i";
}

//  Filtramos si se seleccionó estado del insumo
if (!empty($estado_insumo)) {
  $sql .= " AND insumo.estado_insumo = ?";
  $parametros[] = $estado_insumo;
  $tipos .= "s";
}

$stmt = $conexion->prepare($sql);
$stmt->bind_param($tipos, ...$parametros);
$stmt->execute();
$resultado = $stmt->get_result();

?>

<!--Código HTML-->
<!-- HTML con estilo y tabla -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte de insumos - Supplies iLab</title>
  <link rel="stylesheet" href="../css/13-generar-reporte.css">
</head>
<body>
    <form action="../controladores/13-descargar_pdf_backend.php" method="GET" style="margin-bottom: 15px;">
    <input type="hidden" name="fecha_inicio" value="<?= htmlspecialchars($_GET['fecha_inicio']) ?>">
    <input type="hidden" name="fecha_fin" value="<?= htmlspecialchars($_GET['fecha_fin']) ?>">
    <input type="hidden" name="id_inventario" value="<?= htmlspecialchars($_GET['id_inventario']) ?>">
    <input type="hidden" name="estado_insumo" value="<?= htmlspecialchars($_GET['estado_insumo']) ?>">
    <button type="submit" class="boton">🧾 Descargar PDF</button>
    </form>
  <h2>📄 Resultados del reporte</h2>
    <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Inventario</th>
        <th>Estado</th>
        <th>Fecha de registro</th>
        <th>Fecha de vencimiento</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($resultado->num_rows > 0) { ?>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
          <tr>
            <td><?= htmlspecialchars($fila['id_insumo']) ?></td>
            <td><?= htmlspecialchars($fila['nombre_insumo']) ?></td>
            <td><?= htmlspecialchars($fila['cantidad']) ?></td>
            <td><?= htmlspecialchars($fila['nombre_inventario']) ?></td>
            <td class="estado <?= str_replace('insumo_', '', $fila['estado_insumo']) ?>"><?= estadoInsumo($fila['estado_insumo']) ?></td>
            <td><?= htmlspecialchars($fila['fecha_registro_insumo']) ?></td>
            <td><?= htmlspecialchars($fila['fecha_vencimiento']) ?></td>
          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr><td colspan="6" class="mensaje-vacio">No se encontraron insumos con esos filtros.</td></tr>
      <?php } ?>
    </tbody>
  </table>
  <br>
  <a href="../views/12-reportes.php" class="btn-regresar">⬅️ Volver a reportes</a>
</body>
</html>