<?php
session_start(); // Iniciar sesión

include("../includes/config.php"); // Conexión a la base

// Capturar datos del formulario
$usuario = $_POST['nombre_usuario'];
$password = $_POST['password'];

// Consulta SQL para buscar al usuario
$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$usuario'";
$result = $conexion->query($sql);

// Verificar si el usuario existe
if ($result->num_rows === 1) {
    $datos = $result->fetch_assoc(); // Obtener datos

    // Verificar contraseña (suponiendo que está cifrada)
    if (password_verify($password, $datos['password'])) {
        $_SESSION['usuario'] = $usuario; // Guardar en sesión
        header("Location: ../views/2-dashboard.php"); // Redirigir
    } else {
        header("Location: ../views/1-login.php?error=Contraseña incorrecta");
    }
} else {
    header("Location: ../views/1-login.php?error=Usuario no encontrado");
}
?>
