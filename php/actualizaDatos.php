<?php 
	require_once "conexion.php";
	$conexion = conexion();

	$id = $_POST['id'];
	$u = $_POST['tusuario'];

	$sql = "UPDATE tipo_usuarios SET nombre_tipo= '$u' WHERE id_tipo_usuario='$id'";

	echo $result = mysqli_query($conexion, $sql);
?>
