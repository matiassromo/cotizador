<?php
require_once 'conexion.php';
$conexion = conexion();

$id = $_POST['id'];

$sql = "DELETE FROM usuarios WHERE id_usuario = '$id'";
echo $result = mysqli_query($conexion, $sql);
?>
