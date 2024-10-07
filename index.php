<?php 
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // Evita el caché
header("Pragma: no-cache"); // Evita el caché para navegadores antiguos
header("Expires: 0"); // Forza la expiración inmediata de la página

// Verificar si el usuario es un administrador
if (!isset($_SESSION['id_tipo_usuario']) || $_SESSION['id_tipo_usuario'] != 136) {
    header("Location: login.php");
    exit();
}

// Verificar si hay un mensaje de inicio de sesión exitoso
$mensaje_login = "";
if (isset($_SESSION['mensaje_login_exitoso'])) {
    $mensaje_login = $_SESSION['mensaje_login_exitoso'];
    // Eliminar el mensaje después de mostrarlo para evitar que se muestre siempre
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
    
    <!-- Cargar Bootstrap y otras librerías -->
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    <!-- Cargar scripts de Bootstrap, jQuery y Alertify -->
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
                        <a class="nav-link" href="#" onclick="mostrarFormularioCrearUsuario()">Crear Usuario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarListaUsuarios()">Ver Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="mostrarTiposUsuarios()">Tipos de Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cotizador.php">Ir al Cotizador</a>
                    </li>
                </ul>
                <!-- Botón de cerrar sesión -->
                <!-- Botón de cerrar sesión con confirmación -->
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

    <!-- Modal Agregar Usuario -->
    <div class="modal fade" id="ModalNuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo tipo de usuario</h5>
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


    <!-- Modal Editar Usuario -->
<div class="modal fade" id="ModalEdicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar tipo de usuario</h5>
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
    // Lógica para abrir el modal de edición
// Lógica para abrir el modal de edición
function agregaform(datos) {
    var d = datos.split('||');

    if (d[0] && d[1] && d[2]) {
        // Asigna el ID del usuario al campo oculto
        $('#idpersona').val(d[0]);
        // Asigna el nombre del usuario al campo de edición
        $('#usuariou').val(d[1]);
        // Asigna el estado al select
        $('#estadou').val(d[2]);

        // Mostrar el modal de edición
        $('#ModalEdicion').modal('show');
    } else {
        alertify.error("Datos incompletos para la edición.");
    }
}

// Limpiamos cualquier evento previo en el botón de actualización antes de agregar el nuevo evento
$('#actualizatipousuario').off('click').on('click', function() {
    actualizaDatos();
});

function actualizaDatos() {
    var id = $('#idpersona').val();
    var usuario = $('#usuariou').val();
    var estado = $('#estadou').val();

    if (!id || !usuario || !estado) {
        alertify.error("ID, nombre de usuario o estado no válidos.");
        return;
    }

    var cadena = "id=" + id + "&tusuario=" + usuario + "&estado=" + estado;

    $.ajax({
        type: "POST",
        url: "php/actualizaDatos.php",
        data: cadena,
        success: function(r) {
            if (r == 1) {
                // Mostrar solo una alerta de éxito
                alertify.dismissAll(); // Cierra las alertas previas
                alertify.success("Actualizado con éxito :)");

                // Recargar la tabla automáticamente después de actualizar
                $('#tabla').load('componentes/tabla.php', function() {
                    // Volver a asignar el evento click solo una vez
                    $('#actualizatipousuario').off('click').on('click', function() {
                        actualizaDatos();
                    });
                });

                // Cerrar el modal de edición
                $('#ModalEdicion').modal('hide');
            } else {
                alertify.error("Error del servidor: " + r);
            }
        },
        error: function(xhr, status, error) {
            alertify.error("Fallo en la comunicación con el servidor: " + error);
        }
    });
}

</script>


    <!-- Script para manejar los eventos de los botones -->
    <script>
        $(document).ready(function(){
            // Cargar la tabla de tipos de usuarios
            $('#tabla').load('componentes/tabla.php');

            // Limpiar el campo del modal al abrirlo
            $('#ModalNuevo').on('shown.bs.modal', function () {
                $('#tusuario').val('');  
            });

            // Función para guardar un nuevo tipo de usuario
            $('#guardartipousuario').click(function(){
                var tusuario = $('#tusuario').val();
                agregardatos(tusuario);
            });

            // Función para actualizar un tipo de usuario
            $('#actualizatipousuario').click(function(){
                actualizaDatos();
            });
        });

          // Función para mostrar el formulario de creación de usuario
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

            // Capturamos el evento de envío del formulario
            document.getElementById('crearUsuarioForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Evitar el envío tradicional del formulario

                // Obtener los valores del formulario
                const nombreUsuario = document.getElementById('nombre_usuario').value;
                const email = document.getElementById('email').value;

                // Hacer una petición AJAX para enviar los datos
                $.ajax({
                    type: 'POST',
                    url: 'crear_usuario.php',
                    data: { nombre_usuario: nombreUsuario, email: email },
                    dataType: 'json', // Esperamos una respuesta JSON del servidor
                    success: function (response) {
                        // Mostrar el resultado en función del estado de la respuesta
                        if (response.status === 'success') {
                            alertify.success(response.message);
                        } else {
                            alertify.error(response.message);
                        }
                    },
                    error: function (error) {
                        console.log('Error:', error);
                        alertify.error('Hubo un error en el servidor.');
                    }
                });
            });
        }




        // Función para mostrar la lista de usuarios
        function mostrarListaUsuarios() {
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

        // Función para mostrar la tabla de tipos de usuarios
        function mostrarTiposUsuarios() {
            fetch('componentes/tabla.php') // Asegúrate que esta ruta es correcta
            .then(response => response.text())
            .then(data => {
                document.getElementById('mainContent').innerHTML = data;
            })
            .catch(error => {
                console.error('Error al cargar el contenido:', error);
                alertify.error('Error al cargar los tipos de usuarios.');
            });
        }


        function agregardatos(tusuario) {
            if (tusuario.trim() === "") {
                alertify.error("El campo Tipo de Usuario no puede estar vacío.");
                return;
            }
            
            var cadena = "tusuario=" + tusuario;
            
            $.ajax({
                type: "POST",
                url: "php/agregarDatos.php",
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.success("Agregado con éxito :)");
                        
                        // Recargar la tabla automáticamente después de agregar
                        $('#tabla').load('componentes/tabla.php');

                        // Cerrar el modal de agregar
                        $('#ModalNuevo').modal('hide');
                    } else {
                        alertify.error("Error del servidor: " + r);
                    }
                },
                error: function(xhr, status, error) {
                    alertify.error("Fallo en la comunicación con el servidor: " + error);
                }
            });
        }

        function eliminarDatos(id) {
            var cadena = "id=" + id;

            $.ajax({
                type: "POST",
                url: "php/eliminarDatos.php",
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.success("Eliminado con éxito!");

                        // Recargar la tabla después de eliminar
                        $('#tabla').load('componentes/tabla.php');
                    } else {
                        alertify.error("Error al eliminar el usuario.");
                    }
                },
                error: function(xhr, status, error) {
                    alertify.error("Error de comunicación con el servidor.");
                }
            });
        }

        function preguntarSiNo(id){
            alertify.confirm('Eliminar Registro', '¿Está seguro de eliminar este registro?', 
                function(){ eliminarDatos(id) }, 
                function(){ alertify.error('Cancelado') });
        }


        history.pushState(null, '', location.href);
        window.onpopstate = function () {
            history.go(1);
        };

        // Agregar confirmación para el botón de cerrar sesión
        document.getElementById('cerrarSesionBtn').addEventListener('click', function(e) {
                e.preventDefault(); // Evitar la acción predeterminada del enlace
                alertify.confirm('Confirmar Cierre de Sesión', '¿Está seguro de que desea cerrar sesión?',
                    function() {
                        // Redirigir al logout.php si confirma
                        window.location.href = 'logout.php';
                    },
                    function() {
                        alertify.error('Cancelado');
                    });
            });
</script>
</body>
</html>
