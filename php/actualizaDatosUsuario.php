<?php
require_once 'conexion.php';
$conexion = conexion();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$estado = $_POST['estado'];
$tipo_usuario = $_POST['tipo_usuario'];  // ID del tipo de usuario

$sql = "UPDATE usuarios SET 
        nombre_usuario = '$nombre', 
        apellido_usuario = '$apellido', 
        email = '$email', 
        estado = '$estado', 
        id_tipo_usuario = '$tipo_usuario' 
        WHERE id_usuario = '$id'";

echo mysqli_query($conexion, $sql);
?>
