<?php
// Define la nueva contraseña que deseas para el administrador
$nueva_password = 'admin123';

// Generar el hash de la contraseña
$hash_password = password_hash($nueva_password, PASSWORD_BCRYPT);

// Mostrar el hash generado
echo "Hash de la nueva contraseña: " . $hash_password;
?>
