<?php 

	require_once "conexion.php";
	$conexion=conexion();
	$id = $_POST['id'];
	$u = $_POST['tusuario'];

	$sql = "UPDATE tipo_usuarios set tipo_usuarios= '$u' where id='$id';

	echo $result = mysqli_query($conexion, $sql);
	
 ?>

