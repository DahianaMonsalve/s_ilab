<!--Vista usuarios-->

<!--Código PHP para mensajes o error-->
<?php
if (isset($_GET['error'])) {
  echo "<p style='color:red;'>".$_GET['error']."</p>";
}
if (isset($_GET['mensaje'])) {
  echo "<p style='color:green;'>".$_GET['mensaje']."</p>";
}
?>

<!--Configuración para usuarios-->
<?php
include("../includes/config.php");
session_start();

//Restricción de entrada a la vista según usuario
//------------------------------------------------
if ($_SESSION['rol'] === 'compras' || $_SESSION['rol'] === 'insumos') {
  header("Location: 14-acceso-denegado.php");
  exit();
}
//------------------------------------------------

//Consulta de usuarios activos solamente
$sql = "SELECT id_usuario, nombre_usuario, email, rol FROM usuario WHERE estado_usuario = 'activo'";
$resultado = $conexion->query($sql);

//Traducción del rol 
function mostrarRol($codigoRol) {
  switch ($codigoRol) {
    case 'admin': return 'Administrador';
    case 'insumos': return 'Analista insumos';
    case 'compras': return 'Analista compras';
    default: return ucfirst($codigoRol); // Capitaliza cualquier otro valor
  }
}
?>

<!--Código HTML-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver usuarios - Supplies iLab</title>
  <link rel="stylesheet" href="../css/4-ver-usuarios.css">
</head>
<body>
  <h2>👤 Lista de usuarios</h2>
  <table>
    <thead>
      <tr>
        <th>Nombre del usuario</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($fila = $resultado->fetch_assoc()) { ?>
        <tr>
          <td><?php echo htmlspecialchars($fila['nombre_usuario']); ?></td>
          <td><?php echo htmlspecialchars($fila['email']); ?></td>
          <td><?php echo mostrarRol($fila['rol']); ?></td>
          <td>
            <a href="3-crear-usuario.php?id_usuario=<?php echo $fila['id_usuario']; ?>" title="Editar usuario">✏️</a>
            <a href="../controladores/4-archivar_usuario_backend.php?id_usuario=<?php echo $fila['id_usuario']; ?>" onclick="return confirm('¿Seguro que desea archivar este usuario?');" title="Archivar usuario">📁</a>
            <a href="../controladores/4-eliminar_usuario_backend.php?id_usuario=<?php echo $fila['id_usuario']; ?>" onclick="return confirm('¿Seguro que desea eliminar este usuario?');" title="Eliminar usuario">🗑️</a>
          </td>
        </tr>
      <?php } 
      ?>
    </tbody>
  </table>
 <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
</body>
</html>
