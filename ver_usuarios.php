<?php 
require_once "php/conexion.php";
$conexion = conexion();

$sql_tipos_usuarios = "
    SELECT id_tipo_usuario, nombre_tipo 
    FROM tipo_usuarios 
    WHERE nombre_tipo != 'Administrador'";  // Si quieres excluir el tipo 'Administrador'
$result_tipos_usuarios = mysqli_query($conexion, $sql_tipos_usuarios);
?>


<div id="tabla" class="table-responsive">        
    <div class="col-sm-12">
        <h2 class="text-center">Usuarios</h2>   
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalNuevoUsuario">
                Agregar usuario
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 1 1-1 0v-5h-5a.5.5 0 1 1 0-1h5v-5A.5.5 0 0 1 8 2"/> 
                </svg>
            </button>
        <table class="table table-hover table-condensed table-bordered mt-4">
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Estado</th>
                    <th>Tipo de Usuario</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>  
            </thead>
            <tbody>
                <?php 
            $sql = "
                SELECT u.id_usuario, u.nombre_usuario, u.apellido_usuario, u.email, u.estado, tu.nombre_tipo, tu.id_tipo_usuario
                FROM usuarios u
                JOIN tipo_usuarios tu ON u.id_tipo_usuario = tu.id_tipo_usuario
                WHERE u.id_usuario != 1 AND u.estado = 'A'
            ";
            $result = mysqli_query($conexion, $sql);

            while ($ver = mysqli_fetch_row($result)) {
                $datos = $ver[0] . "||" . $ver[1] . "||" . $ver[2] . "||" . $ver[3] . "||" . $ver[4] . "||" . $ver[5] . "||" . $ver[6];
            ?>

            <tr>
                <td><?php echo $ver[1]; ?></td> <!-- nombre_usuario -->
                <td><?php echo $ver[2]; ?></td> <!-- apellido_usuario -->
                <td><?php echo $ver[3]; ?></td> <!-- email -->
                <td><?php echo $ver[4] == 'A' ? 'Activo' : 'Inactivo'; ?></td> <!-- estado -->
                <td><?php echo $ver[5]; ?></td> <!-- nombre_tipo -->
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalEdicion" onclick="agregaform('<?php echo $datos; ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger" onclick="preguntarSiNo('<?php echo $ver[0]; ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                    </button>
                </td>
            </tr>
            <?php } ?>  
            </tbody>        
        </table>
    </div>
</div>

<!-- Modal para agregar nuevo usuario -->
<div class="modal fade" id="ModalNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label>Nombres</label>
                <input type="text" id="nombreUsuario" class="form-control">
                <label>Apellidos</label>
                <input type="text" id="apellidoUsuario" class="form-control">
                <label>Email</label>
                <input type="email" id="emailUsuario" class="form-control">
                <label>Estado</label>
                <select id="estadoUsuario" class="form-control">
                    <option value="A">Activo</option>
                    <option value="I">Inactivo</option>
                </select>
                <label>Tipo de Usuario</label>
                <select id="tipoUsuario" class="form-control">
                    <?php 
                    if (mysqli_num_rows($result_tipos_usuarios) > 0) {
                        while ($tipo = mysqli_fetch_row($result_tipos_usuarios)) {
                            echo "<option value='{$tipo[0]}'>{$tipo[1]}</option>";
                        }
                    } else {
                        echo "<option value=''>No hay tipos de usuario disponibles</option>";
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
<div class="modal fade" id="ModalEdicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idpersona">
                
                <!-- Nombres -->
                <label>Nombres</label>
                <input type="text" id="nombreu" class="form-control">
                
                <!-- Apellidos -->
                <label>Apellidos</label>
                <input type="text" id="apellidou" class="form-control">
                
                <!-- Email -->
                <label>Email</label>
                <input type="email" id="emailu" class="form-control">
                
                <!-- Estado -->
                <label>Estado</label>
                <select id="estadou" class="form-control">
                    <option value="A">Activo</option>
                    <option value="I">Inactivo</option>
                </select>
                
                <!-- Tipo de Usuario -->
                <label>Tipo de Usuario</label>
                <select id="tipousuariou" class="form-control">
                    <?php 
                    // Cargar dinámicamente los tipos de usuarios en el modal de edición
                    $result_tipos_usuarios = mysqli_query($conexion, $sql_tipos_usuarios);
                    while ($tipo = mysqli_fetch_row($result_tipos_usuarios)) {
                        echo "<option value='{$tipo[0]}'>{$tipo[1]}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="actualizaUsuario">Actualizar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    // Función para agregar un formulario de edición con los datos del usuario
    function agregaform(datos) {
        var d = datos.split('||');
        $('#idpersona').val(d[0]);         // ID del usuario
        $('#nombreu').val(d[1]);           // Nombre
        $('#apellidou').val(d[2]);         // Apellido
        $('#emailu').val(d[3]);            // Email
        $('#estadou').val(d[4]);           // Estado
        $('#tipousuariou').val(d[6]);      // Tipo de Usuario
        $('#ModalEdicion').modal('show');  // Mostrar el modal de edición
    }


    // Función para preguntar si se desea eliminar un registro
    function preguntarSiNo(id) {
        alertify.confirm('Eliminar Registro', '¿Está seguro de eliminar este registro?',
            function(){ eliminarDatosUsuario(id); }, 
            function(){ alertify.error('Cancelado'); });
    }

    // Función para eliminar un registro
    function eliminarDatosUsuario(id) {
        var cadena = "id=" + id + "&estado=I";  // Actualizar el estado a Inactivo
        console.log("Datos enviados:", cadena);  // Revisar los datos que se están enviando
        $.ajax({
            type: "POST",
            url: "php/eliminarDatosUsuario.php",  // El archivo que actualizará el estado
            data: cadena,
            success: function(r) {
                console.log("Respuesta del servidor:", r);  // Ver la respuesta exacta del servidor
                if (r == 1) {
                    alertify.success("Usuario marcado como inactivo!");
                    $('#tabla').load('ver_usuarios.php');  // Recargar la tabla después de la eliminación
                } else {
                    alertify.error("Error al actualizar el estado del usuario: " + r);
                }
            },
            error: function(xhr, status, error) {
                console.log("Error de comunicación con el servidor:", xhr, status, error);
                alertify.error("Error de comunicación con el servidor.");
            }
        });
    }




    // Función para agregar un nuevo usuario
   $('#guardarUsuario').click(function(){
        var nombreUsuario = $('#nombreUsuario').val();
        var apellidoUsuario = $('#apellidoUsuario').val();
        var emailUsuario = $('#emailUsuario').val();
        var estadoUsuario = $('#estadoUsuario').val();
        var tipoUsuario = $('#tipoUsuario').val();  // ID del tipo de usuario

        if (nombreUsuario.trim() === "" || apellidoUsuario.trim() === "" || emailUsuario.trim() === "" || estadoUsuario.trim() === "" || tipoUsuario.trim() === "") {
            alertify.error("Todos los campos son obligatorios.");
            return;
        }

        // Verifica los valores que se están enviando
        console.log({
            nombre: nombreUsuario,
            apellido: apellidoUsuario,
            email: emailUsuario,
            estado: estadoUsuario,
            tipo_usuario: tipoUsuario
        });

        $.ajax({
            type: "POST",
            url: "php/agregarDatosUsuario.php",
            data: { 
                nombre: nombreUsuario, 
                apellido: apellidoUsuario, 
                email: emailUsuario, 
                estado: estadoUsuario, 
                tipo_usuario: tipoUsuario
            },
            success: function(r) {
                console.log("Respuesta del servidor:", r);  // Ver la respuesta exacta del servidor
                if (r == 1) {
                    alertify.success("Usuario agregado con éxito!");
                    $('#tabla').load('ver_usuarios.php');
                    $('#ModalNuevoUsuario').modal('hide');
                } else {
                    alertify.error("Error al agregar el usuario: " + r);
                }
            },
            error: function(xhr, status, error) {
                console.log("Error de comunicación con el servidor:", xhr, status, error);
                alertify.error("Error de comunicación con el servidor.");
            }
        });
    });




    // Función para actualizar un usuario
    $('#actualizaUsuario').click(function(){
        var id = $('#idpersona').val();
        var nombre = $('#nombreu').val();
        var apellido = $('#apellidou').val();
        var email = $('#emailu').val();
        var estado = $('#estadou').val();
        var tipoUsuario = $('#tipousuariou').val();  // ID del tipo de usuario

        if (nombre.trim() === "" || apellido.trim() === "" || email.trim() === "" || estado.trim() === "" || tipoUsuario.trim() === "") {
            alertify.error("Todos los campos son obligatorios.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "php/actualizaDatosUsuario.php",  // Asegúrate de que esta ruta sea correcta
            data: { 
                id: id, 
                nombre: nombre, 
                apellido: apellido, 
                email: email, 
                estado: estado, 
                tipo_usuario: tipoUsuario  // Enviamos el ID del tipo de usuario
            },
            success: function(r) {
                if (r == 1) {
                    alertify.success("Usuario actualizado con éxito!");
                    $('#tabla').load('ver_usuarios.php');
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

</script>
