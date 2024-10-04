<?php 
session_start();

// Verificar si el usuario es un administrador
if (!isset($_SESSION['id_tipo_usuario']) || $_SESSION['id_tipo_usuario'] != 136) {
    header("Location: login.php");
    exit();
}

// Verificar si hay un mensaje de inicio de sesión exitoso
if (isset($_SESSION['mensaje_login_exitoso'])) {
    $mensaje_login = $_SESSION['mensaje_login_exitoso'];
    // Eliminar el mensaje después de mostrarlo para evitar que se muestre siempre
    unset($_SESSION['mensaje_login_exitoso']);
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
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Administrador</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarFormularioCrearUsuario()">Crear Usuario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarListaUsuarios()">Ver Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarTiposUsuarios()">Tipos de Usuarios</a> <!-- Cambio aquí -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cotizador.php">Ir al Cotizador</a>
                    </li>
                </ul>
                <!-- Botón de cerrar sesión -->
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div id="mainContent">
            <h2>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?>!</h2>
            <p>Este es el panel de administración.</p>
        </div>
    </div>

    <!-- Mostrar la alerta si el mensaje existe -->
    <?php if (isset($mensaje_login)): ?>
    <script>
        alertify.success('<?php echo $mensaje_login; ?>');
    </script>
    <?php endif; ?>

    <!-- Script para manejar el cambio de contenido -->
    <script>
        function mostrarFormularioCrearUsuario() {
            document.getElementById('mainContent').innerHTML = `
                <h3>Crear Nuevo Usuario</h3>
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
            `;

            // Agregar funcionalidad para crear usuario con AJAX
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
                    alertify.alert('Resultado', result);
                })
                .catch(error => {
                    alertify.error('Error al crear el usuario');
                });
            });
        }

        function mostrarListaUsuarios() {
            // Realiza la solicitud AJAX para obtener los usuarios
            fetch('ver_usuarios.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('mainContent').innerHTML = `
                    <h3>Lista de Usuarios</h3>
                    ${data} <!-- Aquí se inserta la tabla de usuarios obtenida de ver_usuarios.php -->
                `;
            })
            .catch(error => {
                alertify.error('Error al cargar la lista de usuarios');
            });
        }

        function mostrarTiposUsuarios() {
            // Realiza la solicitud AJAX para obtener el contenido de index.php
            fetch('index.php')  // Aquí cargamos el archivo desde el mismo directorio
            .then(response => response.text())
            .then(data => {
                document.getElementById('mainContent').innerHTML = data;  // Inserta el contenido del archivo dentro del div
            })
            .catch(error => {
                alertify.error('Error al cargar el contenido de tipos de usuarios');
            });
        }




    </script>

    <!-- Scripts de Bootstrap y Alertify -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
</body>
</html>
