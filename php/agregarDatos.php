<?php 

	require_once "conexion.php";
	$conexion=conexion();

	$u = $_POST['tusuario'];

	$sql = "INSERT INTO tipo_usuarios (nombre_tipo) VALUES ('$u')";

	echo $result = mysqli_query($conexion, $sql);
	
 ?>

