<?php
// Define la contraseña que deseas hashear
$nueva_password = 'admin123';

// Generar el hash de la contraseña
$hash_password = password_hash($nueva_password, PASSWORD_BCRYPT);

// Mostrar el hash generado
echo "Hash de la contraseña admin123: " . $hash_password;
?>
