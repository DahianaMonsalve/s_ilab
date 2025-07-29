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
