<?php
session_start();
session_destroy();  // Destruir todas las sesiones activas
header("Location: login.php");  // Redirigir al login después de cerrar sesión
exit();
