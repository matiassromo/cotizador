<?php 
require_once "conexion.php";
$conexion = conexion();

$id = isset($_POST['id']) ? $_POST['id'] : null;
$u = isset($_POST['tusuario']) ? $_POST['tusuario'] : null;
$e = isset($_POST['estado']) ? $_POST['estado'] : null;  // Asegúrate de obtener el estado

if ($id && $u && $e) {
    $sql = "UPDATE tipo_usuarios SET nombre_tipo = '$u', estado = '$e' WHERE id_tipo_usuario = '$id'";
    echo $result = mysqli_query($conexion, $sql);
} else {
    echo "Error: Datos incompletos";
}
?>
