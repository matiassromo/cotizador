<?php 
require_once "conexion.php";
$conexion = conexion();

$id = $_POST['id'];

$sql = "DELETE FROM tipo_usuarios WHERE id_tipo_usuario = '$id'";
echo $result = mysqli_query($conexion, $sql);
?>
