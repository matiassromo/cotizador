<?php
session_start();
require_once 'php/conexion.php';
$conexion = conexion();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Registrarse</h2>
        <form action="php/registrarUsuario.php" method="POST">
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de usuario:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tipo_usuario" class="form-label">Tipo de usuario:</label>
                <select id="tipo_usuario" name="tipo_usuario" class="form-control" required>
                    <?php
                    // Consultar los tipos de usuarios disponibles
                    $sql = "SELECT id_tipo_usuario, nombre_tipo FROM tipo_usuarios";
                    $result = mysqli_query($conexion, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id_tipo_usuario']}'>{$row['nombre_tipo']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
    </div>
</body>
</html>
