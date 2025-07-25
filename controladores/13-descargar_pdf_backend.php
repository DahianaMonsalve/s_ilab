<?php
require '../vendor/autoload.php'; //Ruta para usar composer para la generación de pdf
include("../includes/config.php");//Conexión a la BD

use Mpdf\Mpdf;

//Recuperar filtros
$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];
$id_inventario = $_GET['id_inventario'];
$estado_insumo = $_GET['estado_insumo'];

//Consulta con JOIN 
$sql = "SELECT insumo.*, inventario.nombre_inventario, proveedor.nombre_proveedor 
        FROM insumo 
        JOIN inventario ON insumo.id_inventario = inventario.id_inventario 
        JOIN proveedor ON insumo.id_proveedor = proveedor.id_proveedor
        WHERE insumo.fecha_registro_insumo BETWEEN ? AND ?";
$parametros = [$fecha_inicio, $fecha_fin];
$tipos = "ss";

//Filtro inventario
if (!empty($id_inventario)) {
  $sql .= " AND insumo.id_inventario = ?";
  $parametros[] = $id_inventario;
  $tipos .= "i";
}

//Filtro estado del insumo
if (!empty($estado_insumo)) {
  $sql .= " AND insumo.estado_insumo = ?";
  $parametros[] = $estado_insumo;
  $tipos .= "s";
}

$stmt = $conexion->prepare($sql);
$stmt->bind_param($tipos, ...$parametros);
$stmt->execute();
$resultado = $stmt->get_result();

// Contrucción de HTML
$html = '<h2 style="color:#135a72;">Reporte de insumos</h2>';
$html .= '<table border="1" style="width:100%; border-collapse:collapse;">
  <thead style="background:#e0f0f8;">
    <tr>
      <th>Nombre</th>
      <th>Cantidad</th>
      <th>Inventario</th>
      <th>Porveedor</th>
      <th>Estado</th>
      <th>Fecha registro</th>
      <th>Fecha vencimiento</th>
    </tr>
  </thead><tbody>';

//Traducción del estado del insumo .-. 
function estadoInsumo($estado) {
  switch ($estado) {
    case "insumo_sellado": return "Sellado";
    case "insumo_abierto": return "Abierto";
    case "insumo_terminado": return "Terminado";
    default: return "Desconocido";
  }
}

while ($fila = $resultado->fetch_assoc()) {
  $html .= '<tr>
    <td>' . htmlspecialchars($fila['nombre_insumo']) . '</td>
    <td>' . htmlspecialchars($fila['cantidad']) . '</td>
    <td>' . htmlspecialchars($fila['nombre_inventario']) . '</td>
    <td>' . htmlspecialchars($fila['nombre_proveedor']) . '</td>
    <td>' . estadoInsumo($fila['estado_insumo']) . '</td>
    <td>' . htmlspecialchars($fila['fecha_registro_insumo']) . '</td>
    <td>' . htmlspecialchars($fila['fecha_vencimiento']) . '</td>
  </tr>';
}

$html .= '</tbody></table>';

// 🧾 Generar PDF
$mpdf = new Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output("reporte_suministros.pdf", "D"); // "D" = descarga
?>
