<?php
require_once 'conexion.php';
$conexion = conexion();

if (isset($_POST['id']) && isset($_POST['tipo']) && isset($_POST['estado'])) {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];

    $sql = "UPDATE tipo_usuarios SET nombre_tipo = '$tipo', estado = '$estado' WHERE id_tipo_usuario = '$id'";
    if (mysqli_query($conexion, $sql)) {
        echo 1;  // Devuelve 1 si la actualización fue exitosa
    } else {
        echo 0;  // Devuelve 0 si hubo un error
    }
} else {
    echo 0;  // Devuelve 0 si no se recibieron todos los datos
}
