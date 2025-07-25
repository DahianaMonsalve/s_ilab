<!--Vista alertas-->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Ver alertas - Supplies iLab</title>
  <link rel="stylesheet" href="../css/11-ver-alertas.css">
</head>
<body>
  <h2>📡 Alertas del sistema</h2>

  <section>
    <?php include("../controladores/11-generar_alertas_backend.php"); ?>
  </section>

  <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
</body>
</html>



<!--Código HTML de la vista anterior-->
<!-- <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver alertas - Supplies iLab</title>
  <link rel="stylesheet" href="../css/11-ver-alertas.css">
</head>
<body>
  <h2>📡 Alertas</h2>
  <table>
    <thead>
      <tr>
        <th>ID del insumo</th>
        <th>Fecha de registro</th>
        <th>Nombre</th>
        <th>Fecha de vencimiento</th>
        <th>Lote</th>
        <th>Proveedor</th>
        <th>Tipo de alerta</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>MR-0001</td>
        <td>15/01/2020</td>
        <td>Cloruro de sodio</td>
        <td>15/08/2025</td>
        <td>LM0000875</td>
        <td>Oriente lab</td>
        <td>Fecha de vencimiento próxima</td>
        <td>
          <a href="eliminar_alerta.php?id=1"  title="Eliminar alerta">🗑️</a>
        </td>
      </tr>

     <tr>
        <td>R-0001</td>
        <td>15/01/2025</td>
        <td>Ácido sulfúrico</td>
        <td>15/08/2025</td>
        <td>JK00025825</td>
        <td>Oriente lab</td>
        <td>Stock mínimo</td>
        <td>
          <a href="eliminar_alerta.php?id=2"  title="Eliminar alerta">🗑️</a>
        </td>
      </tr>
    </tbody>
  </table>
  <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
</body>
</html> -->
