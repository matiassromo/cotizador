<?php
require_once 'conexion.php';
$conexion = conexion();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$estado = $_POST['estado'];
$id_tipo_usuario = $_POST['id_tipo_usuario'];

$sql = "UPDATE usuarios SET nombre_usuario = '$nombre', apellido_usuario = '$apellido', email = '$email', estado = '$estado', id_tipo_usuario = '$id_tipo_usuario' WHERE id_usuario = '$id'";

if ($conexion->query($sql)) {
    echo 1;
} else {
    echo 0;
}
?>
