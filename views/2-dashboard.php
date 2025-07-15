<!--Dashboard de sesion-->
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location: 1-login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Supplies iLab</title>
  <link rel="stylesheet" href="../css/2-dashboard.css">
</head>
<body>
  <h1>Bienvenido a Supplies iLab</h1>

  <div class="dashboard">
   
    <!--Espacio donde van las tarjetas desplegables-->
    <div class="tarjetas">

      <!-- Tarjeta: Usuarios -->
      <div class="card">
        <div class="titulo">👤 <br> Usuarios</div>
        <div class="acciones">
          <a href="3-crear-usuario.html">➕ Crear</a>
          <a href="4-ver-usuarios.html">🔍 Ver</a>
        </div>
      </div>

      <!-- Tarjeta: Inventario -->
      <div class="card">
        <div class="titulo">📦 <br> Inventario</div>
        <div class="acciones">
          <a href="5-crear-inventario.html">➕ Crear</a>
          <a href="6-ver-inventarios.html">🔍 Ver</a>
        </div>
      </div>

      <!-- Tarjeta: Insumos -->
      <div class="card">
        <div class="titulo">🧪 <br> Insumos</div>
        <div class="acciones">
          <a href="7-crear-insumo.html">➕ Crear</a>
          <a href="8-ver-insumos.html">🔍 Ver</a>
        </div>
      </div>

      <!-- Tarjeta: Proveedores -->
      <div class="card">
        <div class="titulo">🛠️ <br> Proveedores</div>
        <div class="acciones">
          <a href="9-crear-proveedor.html">➕ Crear</a>
          <a href="10-ver-proveedor.html">🔍 Ver</a>
        </div>
      </div>

      <!-- Tarjeta: Alertas -->
      <div class="card">
        <div class="titulo">📡 <br> Alertas</div>
        <div class="acciones">
          <a href="11-ver-alertas.html">🔔 Ver alertas</a>
        </div>
      </div>

      <!-- Tarjeta: Reportes -->
      <div class="card">
        <div class="titulo">📊 <br> Reportes</div>
        <div class="acciones">
          <a href="12-reportes.html">📈 Generar</a>
        </div>
      </div>

      <!-- Tarjeta: Cerrar sesión -->
      <div class="card salir">
        <div class="titulo">🚪 <br> Cerrar sesión</div>
        <div class="acciones">
          <a href="1-login.html">Salir ahora</a>
          <!-- <a href="logout.php">Salir ahora</a> -->
        </div>
      </div>

    </div>
  </div>
</body>
</html>
