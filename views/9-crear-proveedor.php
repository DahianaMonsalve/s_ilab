<!--Creación de proveedor-->

<!--Código PHP para mensajes o error-->
<?php
if (isset($_GET['error'])) {
  echo "<p style='color:red;'>".$_GET['error']."</p>";
}
if (isset($_GET['mensaje'])) {
  echo "<p style='color:green;'>".$_GET['mensaje']."</p>";
}
?>

<!-- Para reutilizar esta vista en edición de proveedor-->
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

$modo = "crear"; // por defecto, modo editar

if (isset($_GET['id_proveedor'])) {
  $modo = "editar";
  $id_proveedor = $_GET['id_proveedor'];

  $sql = "SELECT nombre_proveedor, email_proveedor, contacto_proveedor, id_usuario FROM proveedor WHERE id_proveedor=?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("i", $id_proveedor);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($nombre_proveedor, $email_proveedor, $contacto_proveedor, $id_usuario);
    $stmt->fetch();
  } else {
    header("Location: 10-ver-proveedor.php?error=Proveedor%20no%20encontrado");
    exit();
  }
} else {
  $nombre_proveedor = "";
  $email_proveedor = "";
  $contacto_proveedor = "";
  
}
?>

<!--Código en HTML-->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear proveedor - Supplies iLab</title>
  <link rel="stylesheet" href="../css/9-crear-proveedor.css">
</head>
<body>
  <h2><?php echo ($modo == "editar") ? "✏️ Editar proveedor" : "➕ Crear nuevo proveedor"; ?></h2>

  <form action="../controladores/<?php echo ($modo == "editar") ? '10-editar_proveedor_backend.php' : '9-guardar_proveedor_backend.php'; ?>" method="POST" class="formulario"> <!--conectar con PHP-->
    <?php if ($modo == "editar") { ?>
    <input type="hidden" name="id_proveedor" value="<?php echo $id_proveedor; ?>">
    <?php } ?>

    <label for="nombre_proveedor">Nombre del proveedor:</label>
    <input type="text" id="nombre_proveedor" name="nombre_proveedor" maxlength="50"  value="<?php echo htmlspecialchars($nombre_proveedor); ?>" required>

    <label for="email_proveedor">Email del proveedor:</label>
    <input type="email" id="email_proveedor" name="email_proveedor" value="<?php echo htmlspecialchars($email_proveedor); ?>"maxlength="50" required>

    <label for="contacto_proveedor">Contacto:</label>
     <input type="text" id="contacto_proveedor" name="contacto_proveedor" maxlength="20" value="<?php echo htmlspecialchars($contacto_proveedor); ?>" required>

    <button type="submit">Guardar proveedor</button>

    <a href="2-dashboard.php" class="btn-regresar">⬅️ Regresar</a>
    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">

  </form>
</body>
</html>
