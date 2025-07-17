<!-- Configuración para la conexión entre la base de datos y PHP -->
<?php
$server = "localhost"; //Servidor, que sería el mío
$user = "root"; //El user por defecto, ya que no configuré ninguno
$password = "MySQL123"; //La contraseña configurada en MySQL
$dbname = "s_ilab"; //El nombre de mi base de datos 

$conexion = new mysqli($server, $user, $password, $dbname); //La conexión

//Verificación de error -- PRUEBA
// if ($conexion->connect_error) {
//     die("Error de conexión: " . $conexion->connect_error); //Esto para verificar si hay un error a la hora de ejecutar el código
// }else {
//     echo "Conectado"; //Si sale conectado en la pantalla es porque sí conectó
// }
?>