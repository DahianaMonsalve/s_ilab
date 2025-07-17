<!--Página para iniciar sesion-->

<!--Código PHP para mensajes o error-->
<?php 
if (isset($_GET['error'])) {
	echo "<p style='color:red;'>".$_GET['error'] . "</p>"; 
}

if (isset($_GET['mensaje'])) {
  echo "<p style='color:green;'>" . $_GET['mensaje'] . "</p>";
}
?>

<!--Código HTML-->
<!DOCTYPE html>
<html lang="es">
<head> 
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio sesión - Supplies iLab</title>
	<link href="../css/1-login.css" rel="stylesheet">
</head>
	<body>
		<div class="cuerpo">
			<h1>Bienvenido a Supplies iLab</h1>
			<form action="../controladores/1-login_usuario.php" method="post">
				<h2>Iniciar sesión</h2>
				<label for="nombre_usuario">Usuario:</label>
				<input type="text" id="nombre_usuario" name="nombre_usuario" required>
				<br>
				<br>
				<label for="password">Contraseña:</label>
				<input type="password" id="password" name="password" required>
				<br>
				<br>
				<input type="submit" value="Iniciar sesión">
			</form>
		</div>
	</body>
</html>
