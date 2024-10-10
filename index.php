<?php 
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

// Verificar si el usuario es un administrador
if (!isset($_SESSION['id_tipo_usuario']) || $_SESSION['id_tipo_usuario'] != 1) {
    header("Location: login.php");
    exit();
}

// Verificar si hay un mensaje de inicio de sesión exitoso
$mensaje_login = "";
if (isset($_SESSION['mensaje_login_exitoso'])) {
    $mensaje_login = $_SESSION['mensaje_login_exitoso'];
    unset($_SESSION['mensaje_login_exitoso']);
}

// Verificar si hay un mensaje de cierre de sesión exitoso
$mensaje_logout = "";
if (isset($_SESSION['mensaje_logout'])) {
    $mensaje_logout = $_SESSION['mensaje_logout'];
    unset($_SESSION['mensaje_logout']);
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand">Administrador</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarListaUsuarios()">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarTiposUsuarios()">Tipos de Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarCotizador()">Cotizador</a>
                    </li>
                </ul>
                <a href="#" class="btn btn-danger" id="cerrarSesionBtn">Cerrar Sesión</a>
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

    <!-- Mostrar alertify si hay mensaje de inicio de sesión -->
    <?php if (!empty($mensaje_login)): ?>
    <script>
        alertify.success("<?php echo $mensaje_login; ?>");
    </script>
    <?php endif; ?>

    <!-- Modal para agregar nuevo tipo de usuario -->
    <div class="modal fade" id="ModalNuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo tipo de usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label>Tipo de usuario</label>
                    <input type="text" id="tusuario" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="guardartipousuario">Agregar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar tipo de usuario -->
    <div class="modal fade" id="ModalEdicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar tipo de usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idpersona">
                    <label>Actualizar usuario</label>
                    <input type="text" id="usuariou" class="form-control">
                    <label>Estado</label>
                    <select id="estadou" class="form-control">
                        <option value="A">Activo</option>
                        <option value="I">Inactivo</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="actualizatipousuario">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para cargar la lista de usuarios
        function mostrarListaUsuarios() {
            $('#mainContent').load('ver_usuarios.php');
        }

        // Función para cargar los tipos de usuarios
        function mostrarTiposUsuarios() {
            $('#mainContent').load('componentes/tabla.php');
        }

        // Función para cargar el cotizador
        function mostrarCotizador() {
            $('#mainContent').load('cotizador.php');
        }

        // Función para agregar un formulario de edición con los datos del usuario
        function agregaform(datos) {
            var d = datos.split('||');
            $('#idpersona').val(d[0]);
            $('#usuariou').val(d[1]);
            $('#estadou').val(d[2]);
            $('#ModalEdicion').modal('show');
        }

        // Función para preguntar si se desea eliminar un registro
        function preguntarSiNo(id) {
            alertify.confirm('Eliminar Registro', '¿Está seguro de eliminar este registro?',
                function(){ eliminarDatos(id); }, 
                function(){ alertify.error('Cancelado'); });
        }

        // Función para eliminar un registro
        function eliminarDatos(id) {
            var cadena = "id=" + id;
            $.ajax({
                type: "POST",
                url: "php/eliminarDatos.php",
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.success("Eliminado con éxito!");
                        $('#tabla').load('componentes/tabla.php');
                    } else {
                        alertify.error("Error al eliminar el registro.");
                    }
                },
                error: function(xhr, status, error) {
                    alertify.error("Error de comunicación con el servidor.");
                }
            });
        }

        // Agregar tipo de usuario
        $('#guardartipousuario').click(function(){
            var tusuario = $('#tusuario').val();
            if (tusuario.trim() === "") {
                alertify.error("El campo Tipo de Usuario no puede estar vacío.");
                return;
            }

            $.ajax({
                type: "POST",
                url: "php/agregarDatos.php",
                data: { tusuario: tusuario },
                success: function(r) {
                    if (r == 1) {
                        alertify.success("Agregado con éxito!");
                        $('#tabla').load('componentes/tabla.php');
                        $('#ModalNuevo').modal('hide');
                    } else {
                        alertify.error("Error al agregar el usuario.");
                    }
                },
                error: function() {
                    alertify.error("Error de comunicación con el servidor.");
                }
            });
        });

        // Actualizar tipo de usuario
        $('#actualizatipousuario').click(function(){
            var id = $('#idpersona').val();
            var usuario = $('#usuariou').val();
            var estado = $('#estadou').val();

            if (usuario.trim() === "" || estado.trim() === "") {
                alertify.error("Todos los campos son obligatorios.");
                return;
            }

            $.ajax({
                type: "POST",
                url: "php/actualizaDatos.php",
                data: { id: id, tusuario: usuario, estado: estado },
                success: function(r) {
                    if (r == 1) {
                        alertify.success("Actualizado con éxito!");
                        $('#tabla').load('componentes/tabla.php');
                        $('#ModalEdicion').modal('hide');
                    } else {
                        alertify.error("Error al actualizar el usuario.");
                    }
                },
                error: function() {
                    alertify.error("Error de comunicación con el servidor.");
                }
            });
        });

        // Agregar confirmación para el botón de cerrar sesión
        document.getElementById('cerrarSesionBtn').addEventListener('click', function(e) {
            e.preventDefault();
            alertify.confirm('Confirmar Cierre de Sesión', '¿Está seguro de que desea cerrar sesión?',
                function() {
                    window.location.href = 'logout.php';
                },
                function() {
                    alertify.error('Cancelado');
                });
        });
    </script>

</body>
</html>
