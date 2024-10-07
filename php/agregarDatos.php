<?php
require_once 'conexion.php'; // Asegúrate de que tienes la conexión a la base de datos
$conexion = conexion();

if (isset($_POST['tusuario'])) {
    $tusuario = $_POST['tusuario'];
    
    $sql = "INSERT INTO tipo_usuarios (nombre_tipo) VALUES ('$tusuario')";
    $result = mysqli_query($conexion, $sql);

    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}

?>
