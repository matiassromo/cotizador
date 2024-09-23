<?php 
	
	function conexion(){
		$servidor="localhost";
		$usuario="root";
		$password="";
		$bd="cotizador";


		$conexion=mysqli_connect($servidor, $usuario, $password, $bd);
		return $conexion;
	}

 ?>