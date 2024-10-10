<?php
require_once 'conexion.php';
$conexion = conexion();

if (isset($_POST['tusuario'])) {
    $tusuario = $_POST['tusuario'];

    $sql = "INSERT INTO tipo_usuarios (nombre_tipo) VALUES ('$tusuario')";
    if ($conexion->query($sql)) {
        echo 1;
    } else {
        echo 0;
    }
}
?>
