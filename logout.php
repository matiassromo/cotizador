<?php
session_start();
// Destruir todas las variables de sesión
session_unset();
session_destroy();

// Establecer un mensaje de sesión para indicar el cierre de sesión exitoso
session_start();
$_SESSION['mensaje_logout'] = "Sesión cerrada exitosamente.";

// Redirigir al formulario de login
header("Location: login.php");
exit();
?>
