<?php 
require_once "conexion.php";
$conexion = conexion();

$u = trim($_POST['tusuario']);

// Validar que el campo no esté vacío
if (empty($u)) {
    echo 0;  // Respuesta de error
    exit();  // Detener la ejecución del script
}

$sql = "INSERT INTO tipo_usuarios (nombre_tipo) VALUES ('$u')";

echo $result = mysqli_query($conexion, $sql);
?>
