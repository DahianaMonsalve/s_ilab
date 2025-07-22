<?php
//Activar sesión y conexión con la BD
session_start();
include("../includes/config.php");

//Traducción del estado del insumo 
function estadoInsumo($estado) {
  switch ($estado) {
    case "insumo_sellado": return "Sellado";
    case "insumo_abierto": return "Abierto";
    case "insumo_terminado": return "Terminado";
    default: return "Desconocido";
  }
}

//Fecha actual y rango de vencimiento (en los próximos 30 días)
$fecha_actual = date("Y-m-d");
$fecha_limite = date("Y-m-d", strtotime("+30 days"));

//Consulta: alerta por vencimiento próximo
$sql_vencimiento = "
SELECT insumo.id_insumo, insumo.fecha_registro_insumo, insumo.nombre_insumo, insumo.estado_insumo, insumo.fecha_vencimiento, insumo.lote, proveedor.nombre_proveedor, 
'Fecha de vencimiento próxima' AS tipo_alerta
FROM insumo
JOIN proveedor ON insumo.id_proveedor = proveedor.id_proveedor
WHERE insumo.fecha_vencimiento <= ? 
AND insumo.fecha_vencimiento >= ?
AND insumo.estado_insumo != 'insumo_terminado'
ORDER BY insumo.fecha_vencimiento ASC
";
$stmt_venc = $conexion->prepare($sql_vencimiento);
$stmt_venc->bind_param("ss", $fecha_limite, $fecha_actual);
$stmt_venc->execute();
$alertas_vencimiento = $stmt_venc->get_result();


//Consulta:  alerta insumos vencidos aún activos (estado insumo abierto o sellado)
$sql_vencidos_activos = "
SELECT insumo.id_insumo, insumo.fecha_registro_insumo, insumo.nombre_insumo, insumo.estado_insumo, insumo.fecha_vencimiento, insumo.lote, proveedor.nombre_proveedor, 
'Insumo vencido' AS tipo_alerta
FROM insumo
JOIN proveedor ON insumo.id_proveedor = proveedor.id_proveedor
WHERE insumo.fecha_vencimiento < ?
AND insumo.estado_insumo IN ('insumo_sellado', 'insumo_abierto')
ORDER BY insumo.fecha_vencimiento ASC
";
$stmt_vencido = $conexion->prepare($sql_vencidos_activos);
$stmt_vencido->bind_param("s", $fecha_actual);
$stmt_vencido->execute();
$alertas_vencidos = $stmt_vencido->get_result();


//Consulta: alerta por bajo stock por CAS, donde stock <1
$sql_stock = "
SELECT cas 
FROM insumo 
GROUP BY cas 
HAVING SUM(estado_insumo IN ('insumo_sellado','insumo_abierto')) < 1
";
$result_stock = $conexion->query($sql_stock);
$cas_alerta = [];
while ($fila = $result_stock->fetch_assoc()) {
  $cas_alerta[] = $fila['cas'];
}

//Obtener insumos asociados a esos CAS
$alertas_stock = [];
if (!empty($cas_alerta)) {
  $cas_in = str_repeat("?,", count($cas_alerta) - 1) . "?";
  $sql_insumos_alerta = "
  SELECT insumo.id_insumo, insumo.fecha_registro_insumo, insumo.nombre_insumo, insumo.estado_insumo, insumo.fecha_vencimiento, insumo.lote, proveedor.nombre_proveedor, 
  'Stock mínimo por CAS' AS tipo_alerta
  FROM insumo
  JOIN proveedor ON insumo.id_proveedor = proveedor.id_proveedor
  WHERE cas IN ($cas_in)
  ";
  $stmt_cas = $conexion->prepare($sql_insumos_alerta);
  $stmt_cas->bind_param(str_repeat("s", count($cas_alerta)), ...$cas_alerta);
  $stmt_cas->execute();
  $alertas_stock = $stmt_cas->get_result();
}

//Alertas en HTML
echo "<table>";
echo "<thead><tr>
  <th>ID del insumo</th>
  <th>Fecha de registro</th>
  <th>Nombre</th>
  <th>Estado</th>
  <th>Fecha de vencimiento</th>
  <th>Lote</th>
  <th>Proveedor</th>
  <th>Tipo de alerta</th>
</tr></thead><tbody>";

//Mostrar alertas de vencimiento
while ($fila = $alertas_vencimiento->fetch_assoc()) {
  echo "<tr class='alerta-vencimiento'>";
  echo "<td>" . htmlspecialchars($fila['id_insumo']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['fecha_registro_insumo']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['nombre_insumo']) . "</td>";
  echo "<td>" . estadoInsumo($fila['estado_insumo']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['fecha_vencimiento']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['lote']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['nombre_proveedor']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['tipo_alerta']) . "</td>";
  echo "</tr>";
}

//Mostrar alertas de vencimiento activas--insumos abiertos o sellados vencidos
while ($fila = $alertas_vencidos->fetch_assoc()) {
  echo "<tr class='alerta-vencido-activo'>";
  echo "<td>" . htmlspecialchars($fila['id_insumo']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['fecha_registro_insumo']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['nombre_insumo']) . "</td>";
  echo "<td>" . estadoInsumo($fila['estado_insumo']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['fecha_vencimiento']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['lote']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['nombre_proveedor']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['tipo_alerta']) . "</td>";
  echo "</tr>";
}

//Mostrar alertas de stock por CAS
while ($fila = $alertas_stock->fetch_assoc()) {
  echo "<tr class='alerta-stock'>";
  echo "<td>" . htmlspecialchars($fila['id_insumo']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['fecha_registro_insumo']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['nombre_insumo']) . "</td>";
  echo "<td>" . estadoInsumo($fila['estado_insumo']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['fecha_vencimiento']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['lote']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['nombre_proveedor']) . "</td>";
  echo "<td>" . htmlspecialchars($fila['tipo_alerta']) . "</td>";
  echo "</tr>";
}

echo "</tbody></table>";
?>

