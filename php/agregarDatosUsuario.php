<?php
require_once 'conexion.php';
$conexion = conexion();

if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['estado']) && isset($_POST['tipo_usuario'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $estado = mysqli_real_escape_string($conexion, $_POST['estado']);
    $tipo_usuario = mysqli_real_escape_string($conexion, $_POST['tipo_usuario']);

    $sql = "INSERT INTO usuarios (nombre_usuario, apellido_usuario, email, estado, id_tipo_usuario) VALUES ('$nombre', '$apellido', '$email', '$estado', '$tipo_usuario')";

    if (mysqli_query($conexion, $sql)) {
        echo 1;  // Retorna 1 si la inserción fue exitosa
    } else {
        echo "Error: " . mysqli_error($conexion);  // Muestra el error
    }
} else {
    echo 0;  // Retorna 0 si no se recibieron todos los campos
}
?>
