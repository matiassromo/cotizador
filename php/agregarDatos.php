<?php
require_once 'conexion.php';
$conexion = conexion();

if (isset($_POST['tusuario']) && isset($_POST['estado'])) {
    $tusuario = mysqli_real_escape_string($conexion, $_POST['tusuario']);
    $estado = mysqli_real_escape_string($conexion, $_POST['estado']);

    $sql = "INSERT INTO tipo_usuarios (nombre_tipo, estado) VALUES ('$tusuario', '$estado')";

    if (mysqli_query($conexion, $sql)) {
        echo 1;  // Devuelve 1 si fue exitoso
    } else {
        echo 0;  // Devuelve 0 si hubo un error
    }
} else {
    echo 0;  // Si no llegan los campos requeridos, devuelve 0
}
?>
