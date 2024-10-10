<?php
require_once "php/conexion.php";
$conexion = conexion();
?>

<div id="tabla_usuarios" class="row">
    <div class="col-sm-12">
        <h2>Usuarios</h2>
        <caption>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalNuevoUsuario">
                Agregar usuario
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 1 1-1 0v-5h-5a.5.5 0 1 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                </svg>
            </button>
        </caption>
        <h2></h2>
        <table class="table table-hover table-condensed table-bordered">
            <tr>
                <td>Nombres</td>
                <td>Apellidos</td>
                <td>Email</td>
                <td>Estado</td>
                <td>Tipo de Usuario</td>
                <td>Editar</td>
                <td>Eliminar</td>
            </tr>

            <?php
            $sql = "
                SELECT u.id_usuario, u.nombre_usuario, u.apellido_usuario, u.email, u.estado, tu.nombre_tipo 
                FROM usuarios u
                JOIN tipo_usuarios tu ON u.id_tipo_usuario = tu.id_tipo_usuario
            ";
            $result = mysqli_query($conexion, $sql);

            while ($ver = mysqli_fetch_row($result)) {
                // Pasar todos los datos a la función para cargar el formulario
                $datos = $ver[0] . "||" . $ver[1] . "||" . $ver[2] . "||" . $ver[3] . "||" . $ver[4] . "||" . $ver[5];
            ?>

            <tr>
                <td><?php echo $ver[1]; ?></td> <!-- nombre_usuario -->
                <td><?php echo $ver[2]; ?></td> <!-- apellido_usuario -->
                <td><?php echo $ver[3]; ?></td> <!-- email -->
                <td><?php echo $ver[4] == 'A' ? 'Activo' : 'Inactivo'; ?></td> <!-- estado -->
                <td><?php echo $ver[5]; ?></td> <!-- tipo de usuario -->
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalEdicionUsuario" onclick="agregaformUsuario('<?php echo $datos; ?>')">
                        <!-- Ícono de editar -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger" onclick="preguntarSiNoUsuario('<?php echo $ver[0]; ?>')">
                        <!-- Ícono de eliminar -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                    </button>
                </td>
            </tr>

            <?php
            }
            ?>
        </table>
    </div>
</div>

<!-- Modal para agregar usuario -->
<div class="modal fade" id="ModalNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
            </div>
            <div class="modal-body">
                <label>Nombres</label>
                <input type="text" id="nombre_usuario" class="form-control">
                <label>Apellidos</label>
                <input type="text" id="apellido_usuario" class="form-control">
                <label>Email</label>
                <input type="email" id="email" class="form-control">
                <label>Estado</label>
                <select id="estado" class="form-control">
                    <option value="A">Activo</option>
                    <option value="I">Inactivo</option>
                </select>
                <label>Tipo de Usuario</label>
                <select id="id_tipo_usuario" class="form-control">
                    <?php
                    $sql_tipos = "SELECT id_tipo_usuario, nombre_tipo FROM tipo_usuarios";
                    $result_tipos = mysqli_query($conexion, $sql_tipos);

                    while ($row_tipo = mysqli_fetch_assoc($result_tipos)) {
                        echo "<option value='" . $row_tipo['id_tipo_usuario'] . "'>" . $row_tipo['nombre_tipo'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="guardarUsuario">Agregar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="ModalEdicionUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idusuario">
                <label>Nombres</label>
                <input type="text" id="nombre_usuariou" class="form-control">
                <label>Apellidos</label>
                <input type="text" id="apellido_usuariou" class="form-control">
                <label>Email</label>
                <input type="email" id="emailu" class="form-control">
                <label>Estado</label>
                <select id="estadou" class="form-control">
                    <option value="A">Activo</option>
                    <option value="I">Inactivo</option>
                </select>
                <label>Tipo de Usuario</label>
                <select id="id_tipo_usuariou" class="form-control">
                    <?php
                    $sql_tipos = "SELECT id_tipo_usuario, nombre_tipo FROM tipo_usuarios";
                    $result_tipos = mysqli_query($conexion, $sql_tipos);

                    while ($row_tipo = mysqli_fetch_assoc($result_tipos)) {
                        echo "<option value='" . $row_tipo['id_tipo_usuario'] . "'>" . $row_tipo['nombre_tipo'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="actualizarUsuario">Guardar cambios</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function agregaformUsuario(datos) {
        var d = datos.split('||');
        $('#idusuario').val(d[0]);
        $('#nombre_usuariou').val(d[1]);
        $('#apellido_usuariou').val(d[2]);
        $('#emailu').val(d[3]);
        $('#estadou').val(d[4]);
        $('#id_tipo_usuariou').val(d[5]); // Para seleccionar el tipo de usuario correcto
    }

    function preguntarSiNoUsuario(id) {
        alertify.confirm('Eliminar Registro', '¿Está seguro de eliminar este registro?',
            function() { eliminarDatosUsuario(id); },
            function() { alertify.error('Cancelado'); });
    }

    function eliminarDatosUsuario(id) {
        var cadena = "id=" + id;
        $.ajax({
            type: "POST",
            url: "php/eliminarDatosUsuario.php",
            data: cadena,
            success: function(r) {
                if (r == 1) {
                    alertify.success("Eliminado con éxito!");
                    $('#tabla_usuarios').load('ver_usuarios.php');
                } else {
                    alertify.error("Error al eliminar el registro.");
                }
            }
        });
    }

    $('#guardarUsuario').click(function() {
    var nombre = $('#nombre_usuario').val();
    var apellido = $('#apellido_usuario').val();
    var email = $('#email').val();
    var estado = $('#estado').val();
    var id_tipo_usuario = $('#id_tipo_usuario').val();  // Obtener el tipo de usuario

    // Crear un objeto de datos en lugar de concatenar una cadena
    var datos = {
        nombres: nombre,
        apellidos: apellido,
        correo: email,
        estado: estado,
        tipo_usuario: id_tipo_usuario
    };

    // Hacer la solicitud AJAX
    $.ajax({
        type: "POST",
        url: "php/agregarDatosUsuario.php",
        data: datos,  // Enviar el objeto de datos directamente
        success: function(r) {
            if (r == 1) {
                $('#tabla_usuarios').load('ver_usuarios.php');  // Recargar la tabla de usuarios
                alertify.success("Usuario agregado con éxito!");
            } else {
                alertify.error("Error al agregar el usuario.");
            }
        },
        error: function() {
            alertify.error("Error de conexión con el servidor.");
        }
    });
});


    $('#actualizarUsuario').click(function() {
        var id = $('#idusuario').val();
        var nombre = $('#nombre_usuariou').val();
        var apellido = $('#apellido_usuariou').val();
        var email = $('#emailu').val();
        var estado = $('#estadou').val();
        var id_tipo_usuario = $('#id_tipo_usuariou').val();

        var cadena = "id=" + id + "&nombre=" + nombre + "&apellido=" + apellido + "&email=" + email + "&estado=" + estado + "&id_tipo_usuario=" + id_tipo_usuario;

        $.ajax({
            type: "POST",
            url: "php/actualizaDatosUsuario.php",
            data: cadena,
            success: function(r) {
                if (r == 1) {
                    $('#tabla_usuarios').load('ver_usuarios.php');
                    alertify.success("Usuario actualizado con éxito!");
                } else {
                    alertify.error("Error al actualizar el usuario.");
                }
            }
        });
    });
</script>
