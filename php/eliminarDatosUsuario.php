<?php
require_once 'conexion.php';
$conexion = conexion();

$id = $_POST['id'];

// Actualizar el estado del usuario a 'I' (Inactivo) en lugar de eliminarlo
$sql = "UPDATE usuarios SET estado = 'I' WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo 1;  // Indicar éxito
} else {
    echo "Error en la actualización: " . $stmt->error;  // Mostrar el error exacto en caso de fallo
}

$stmt->close();
$conexion->close();
?>
