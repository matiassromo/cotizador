<?php
session_start();

// Verificar si el usuario es un administrador
if (!isset($_SESSION['id_tipo_usuario']) || $_SESSION['id_tipo_usuario'] != 136) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Administrador</title>
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?>!</h2>
        <p>Este es el panel de administración.</p>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        <a href="index.php" class="btn btn-primary">Ir al Inicio</a>

        <!-- Formulario para crear nuevo usuario -->
        <h3 class="mt-5">Crear Nuevo Usuario</h3>
        <form id="crearUsuarioForm">
            <div class="form-group">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Crear Usuario</button>
            </div>
        </form>
    </div>

    <!-- Script para manejar el envío del formulario con AJAX -->
    <script>
        document.getElementById('crearUsuarioForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío tradicional del formulario

            var formData = new FormData(this);

            // Realiza la solicitud AJAX
            fetch('crear_usuario.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                // Muestra el resultado con Alertify
                alertify.alert('Resultado', result);
            })
            .catch(error => {
                alertify.error('Error al crear el usuario');
            });
        });
    </script>
</body>
</html>