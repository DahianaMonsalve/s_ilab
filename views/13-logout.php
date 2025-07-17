<?php
session_start();
session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión actual

header("Location: ../views/1-login.php?mensaje=La%20sesion%20ha%20sido%20cerrada%20correctamente"); // Redirige al login 
exit();
?>