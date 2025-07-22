<!--Creación de usuario-->

<!--Código PHP para mensajes o error-->
<?php
if (isset($_GET['error'])) {
  echo "<p style='color:red;'>".$_GET['error']."</p>";
}
if (isset($_GET['mensaje'])) {
  echo "<p style='color:green;'>".$_GET['mensaje']."</p>";
}
?>

<!-- Para reutilizar esta vista en edición de usuario-->
<?php
include("../includes/config.php");
session_start();

//Restricción de entrada a la vista según usuario
//------------------------------------------------
if ($_SESSION['rol'] === 'analista_compras') {
  header("Location: acceso_denegado.php");
  exit();
}
//------------------------------------------------

$modo = "crear"; // por defecto

if (isset($_GET['id_usuario'])) {
  $modo = "editar";
  $id_usuario = $_GET['id_usuario'];

  $sql = "SELECT nombre_usuario, email, rol FROM usuario WHERE id_usuario=?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("i", $id_usuario);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($nombre_usuario, $email, $rol);
    $stmt->fetch();
  } else {
    header("Location: 4-ver-usuarios.php?error=Usuario%20no%20encontrado");
    exit();
  }
} else {
  $nombre_usuario = $email = $rol = "";
}
?>

<!--Código HTML-->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear usuario - Supplies iLab</title>
  <link rel="stylesheet" href="../css/3-crear-usuario.css">
</head>
<body>
  <h2><?php echo ($modo == "editar") ? "✏️ Editar usuario" : "➕ Crear nuevo usuario"; ?></h2>

  <form class="formulario" action="../controladores/<?php echo ($modo == "editar") ? '4-editar_usuario_backend.php' : '3-guardar_usuario_backend.php'; ?>" method="POST">
  <?php if ($modo == "editar") echo '<input type="hidden" name="id_usuario" value="'.$id_usuario.'">'; ?> <!--Cuando esté en modo edición-->

    <label for="nombre_usuario">Nombre completo:</label>
    <input type="text" id="nombre_usuario" name="nombre_usuario" maxlength="150" value="<?php echo htmlspecialchars($nombre_usuario); ?>" required>

    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" maxlength="100" value="<?php echo htmlspecialchars($email); ?>" required>

    <label for="password">Contraseña</label>
    <input type="password" id="password" name="password" maxlength="255" required>

    <label for="rol">Rol:</label>
    <select id="rol" name="rol" required>
      <option value="admin" <?php if ($rol=="admin") echo "selected"; ?>>Administrador</option>
      <option value="insumos" <?php if ($rol=="insumos") echo "selected"; ?>>Analista insumos</option>
      <option value="compras" <?php if ($rol=="compras") echo "selected"; ?>>Analista compras</option>
    </select>

    <button type="submit">Guardar usuario</button>
    <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
  </form>
</body>
</html>
