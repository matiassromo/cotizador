<?php
require_once 'conexion.php';
$conexion = conexion();

if (isset($_POST['tusuario'])) {
    $tusuario = mysqli_real_escape_string($conexion, $_POST['tusuario']);

    $sql = "INSERT INTO tipo_usuarios (nombre_tipo) VALUES ('$tusuario')";

    if (mysqli_query($conexion, $sql)) {
        echo 1;  // Devuelve 1 si fue exitoso
    } else {
        echo 0;  // Devuelve 0 si hubo un error
    }
} else {
    echo 0;  // Si no llegan los campos requeridos, devuelve 0
}
?>
