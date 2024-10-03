<?php
function conexion() {
    $servidor = "localhost";  // Cambia estos valores si es necesario
    $usuario = "root";
    $password = "";
    $bd = "cotizador";  // Asegúrate de que el nombre de la base de datos sea el correcto

    $conexion = new mysqli($servidor, $usuario, $password, $bd);

    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }
    
    return $conexion;

    
}
?>
