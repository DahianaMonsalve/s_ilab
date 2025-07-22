<?php
session_start(); // Iniciar sesión 

include("../includes/config.php"); // Conexión a la base

// Capturar datos del formulario
$usuario = $_POST['nombre_usuario'];
$password = $_POST['password'];

// Consulta SQL para buscar al usuario
$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$usuario'";
$result = $conexion->query($sql); //se conecta a la base de datos y realiza la consulta $sql

// Verificar si el usuario existe y la contraseña
if ($result->num_rows === 1) { //result es la consulta guardada, un atritubuto es num_rows es el número de resultados que coincidieron y 
// se hace una comparación de valor y tipo con  ===
    $datos = $result->fetch_assoc(); // Obtener datos, fetch_assoc convierte el resultado en un array asociativo, donde me devuelve la 
    // fila del nombre_usuario.

    // Verificar contraseña (suponiendo que está cifrada)
    if (password_verify($password, $datos['password'])) {
        $_SESSION['usuario'] = $usuario; // Guardar en sesión
        $_SESSION['id_usuario'] = $datos['id_usuario']; // Guarda el id del usuario para futura trazabilidad
        $_SESSION['rol'] = $usuario['rol']; //se guarda el rol para permisos
        header("Location: ../views/2-dashboard.php"); // Redirige al dashboard
    } else {
        header("Location: ../views/1-login.php?error=Contraseña incorrecta"); // Cuando la contraseña es incorrecta
    }
} else {
    header("Location: ../views/1-login.php?error=Usuario no encontrado"); // Cuando el usuario no se encuentra en la base de datos
}
?>
