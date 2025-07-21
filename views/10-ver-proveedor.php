<!--Ver proveedores-->

<!--Código PHP para mensajes o error-->
<?php
if (isset($_GET['error'])) {
  echo "<p style='color:red;'>".$_GET['error']."</p>";
}
if (isset($_GET['mensaje'])) {
  echo "<p style='color:green;'>".$_GET['mensaje']."</p>";
}
?>

<!--Código HTML-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de proveedores - Supplies iLab</title>
  <link rel="stylesheet" href="../css/10-ver-proveedor.css">
</head>
<body>
  <h2>🛠️ Lista de proveedores</h2>
  <table>
    <thead>
      <tr>
        <th>Nombre del proveedor</th>
        <th>Email </th>
        <th>Contacto </th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include("../includes/config.php");
      session_start();

      $sql = "
      SELECT id_proveedor, nombre_proveedor, email_proveedor, contacto_proveedor 
      FROM proveedor 
      WHERE estado_proveedor = 'activo'
      ";

      $resultado = $conexion->query($sql);

      if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($fila['nombre_proveedor']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['email_proveedor']) . "</td>";
          echo "<td>" . htmlspecialchars($fila['contacto_proveedor']) . "</td>";
          echo "<td>
                  <a href='9-crear-proveedor.php?id_proveedor=" . $fila['id_proveedor'] . "' title='Editar proveedor'>✏️</a>
                  <a href='../controladores/10-archivar_proveedor_backend.php?id_proveedor=" . $fila['id_proveedor'] . "' title='Archivar proveedor' onclick=\"return confirm('¿Seguro que desea archivar proveedor?');\">📁</a>
                  <a href='../controladores/10-eliminar_proveedor_backend.php?id_proveedor=" . $fila['id_proveedor'] . "' title='Eliminar proveedor' onclick=\"return confirm('¿Seguro que desea eliminar proveedor?');\">🗑️</a>
                </td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4'>No hay proveedores registrados.</td></tr>";
      }
      ?>
    </tbody>
  </table>
  <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
</body>
</html>
