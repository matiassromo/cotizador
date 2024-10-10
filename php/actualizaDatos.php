<?php
require_once 'conexion.php';
$conexion = conexion();

if (isset($_POST['id']) && isset($_POST['tusuario']) && isset($_POST['estado'])) {
    $id = $_POST['id'];
    $tusuario = $_POST['tusuario'];
    $estado = $_POST['estado'];

    $sql = "UPDATE tipo_usuarios SET nombre_tipo = '$tusuario', estado = '$estado' WHERE id_tipo_usuario = '$id'";
    if ($conexion->query($sql)) {
        echo 1;
    } else {
        echo 0;
    }
}
?>
