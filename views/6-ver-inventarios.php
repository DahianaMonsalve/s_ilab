<!--Vista de inventarios-->

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
  <title>Lista de inventarios - Supplies iLab</title>
  <link rel="stylesheet" href="../css/6-ver-inventarios.css">
</head>
<body>
  <h2>📦 Lista de inventarios</h2>
  <table>
    <thead>
      <tr>
        <th>Nombre del inventario</th>
        <th>Fecha de registro</th>
        <th>Estado del inventario</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include("../includes/config.php");
      session_start();

      $sql = "SELECT id_inventario, nombre_inventario, fecha_registro, estado_inventario FROM inventario";
      $resultado = $conexion->query($sql);

      if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($fila['nombre_inventario']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['fecha_registro']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['estado_inventario']) . "</td>";
          echo "<td>
                  <a href='5-crear-inventario.php?id_inventario=" . $fila['id_inventario'] . "' title='Editar inventario'>✏️</a>
                  <a href='../controladores/6-eliminar_inventario_backend.php?id_inventario=" . $fila['id_inventario'] . "' title='Eliminar inventario' onclick=\"return confirm('¿Eliminar inventario?');\">🗑️</a>
                </td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No hay inventarios registrados.</td></tr>";
      }
      ?>
    </tbody>

  </table>
  <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
</body>
</html>
