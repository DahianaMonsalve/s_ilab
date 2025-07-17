<!--Vista insumos-->

<!--Código PHP para mensajes o error-->
<?php
if (isset($_GET['error'])) {
  echo "<p style='color:red;'>".$_GET['error']."</p>";
}
if (isset($_GET['mensaje'])) {
  echo "<p style='color:green;'>".$_GET['mensaje']."</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver insumos - Supplies iLab</title>
  <link rel="stylesheet" href="../css/8-ver-insumos.css">
</head>
<body>
  <h2>🧪 Lista de insumos</h2>
  <table>
    <thead>
      <tr>
        <th>ID del insumo</th>
        <th>Fecha de registro</th>
        <th>Nombre del insumo</th>
        <th>Cantidad</th>
        <th>Fecha de vencimiento</th>
        <th>Lote</th>
        <th>Proveedor</th>
        <th>Inventario</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include("../includes/config.php");
      session_start();

      $sql = "
      SELECT 
      insumo.id_insumo, insumo.nombre_insumo, insumo.fecha_vencimiento, 
      insumo.fecha_registro_insumo, insumo.cantidad, insumo.lote, 
      proveedor.nombre_proveedor, inventario.nombre_inventario
      FROM insumo
      JOIN proveedor ON insumo.id_proveedor = proveedor.id_proveedor
      JOIN inventario ON insumo.id_inventario = inventario.id_inventario
      ORDER BY insumo.id_insumo DESC
      ";
      $resultado = $conexion->query($sql);

      if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($fila['id_insumo']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['fecha_registro_insumo']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['nombre_insumo']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['cantidad']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['fecha_vencimiento']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['lote']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['nombre_proveedor']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['nombre_inventario']) . "</td>";
          echo "<td>
                  <a href='7-crear-insumo.php?id_insumo=" . $fila['id_insumo'] . "' title='Editar insumo'>✏️</a>
                  <a href='../controladores/8-eliminar_insumo_backend.php?id_insumo=" . $fila['id_insumo'] . "' title='Eliminar insumo' onclick=\"return confirm('¿Eliminar insumo?');\">🗑️</a>
                </td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No hay insumos registrados.</td></tr>";
      }
      ?>
    </tbody>
  </table>
  <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
</body>
</html>
