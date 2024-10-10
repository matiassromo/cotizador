<?php
require_once 'conexion.php';
$conexion = conexion();

if (isset($_POST['nombres']) && isset($_POST['apellidos']) && isset($_POST['correo']) && isset($_POST['estado']) && isset($_POST['tipo_usuario'])) {
    $nombre_usuario = $_POST['nombres'];
    $apellido_usuario = $_POST['apellidos'];
    $email = $_POST['correo'];
    $estado = $_POST['estado'];
    $id_tipo_usuario = $_POST['tipo_usuario']; // Tipo de usuario enviado desde el formulario

    // Hash de la contraseña por defecto
    $password = password_hash('default_password', PASSWORD_DEFAULT);  // Cambia esta contraseña según sea necesario

    // Ajusta los nombres de las columnas a los de tu tabla
    $sql = "INSERT INTO usuarios (nombre_usuario, apellido_usuario, email, password, estado, id_tipo_usuario) 
            VALUES ('$nombre_usuario', '$apellido_usuario', '$email', '$password', '$estado', '$id_tipo_usuario')";
    
    if ($conexion->query($sql)) {
        echo 1; // Éxito
    } else {
        echo "Error SQL: " . $conexion->error; // Mostrar el error SQL si falla
    }
} else {
    echo "Error: Datos incompletos"; // Mostrar error si faltan datos
}
?>
