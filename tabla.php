<?php 
require_once "php/conexion.php";  
$conexion = conexion();  
?>

<div id="tabla" class="row">
    <div class="col-sm-12">
        <h2 class="text-center">Tipos de Usuario</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalNuevoTipo">
            Agregar tipo de usuario
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 1 1-1 0v-5h-5a.5.5 0 1 1 0-1h5v-5A.5.5 0 0 1 8 2"/> 
            </svg>
        </button>
        <table class="table table-hover table-condensed table-bordered mt-4">
            <thead>
                <tr>
                    <th>Tipo de usuario</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT id_tipo_usuario, nombre_tipo, estado FROM tipo_usuarios WHERE nombre_tipo != 'Administrador'";
                $result = mysqli_query($conexion, $sql); 
                
                while ($ver = mysqli_fetch_row($result)) {
                    $datos = $ver[0] . "||" . $ver[1] . "||" . $ver[2];
                ?>
                <tr>
                    <td><?php echo $ver[1]; ?></td>
                    <td><?php echo $ver[2] == 'A' ? 'Activo' : 'Inactivo'; ?></td>
                    <td>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalEdicion" onclick="agregaform('<?php echo $datos; ?>')">
                           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
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

<!-- Modal para agregar nuevo tipo de usuario -->
<div class="modal fade" id="ModalNuevoTipo" tabindex="-1" aria-labelledby="ModalNuevoTipoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalNuevoTipoLabel">Nuevo Tipo de Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="tusuario">Tipo de Usuario</label>
          <input type="text" id="tusuario" class="form-control">
        </div>
        <div class="form-group">
          <label for="estado">Estado</label>
          <select id="estado" class="form-control">
            <option value="A">Activo</option>
            <option value="I">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardartipousuario">Agregar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal para editar usuario -->
<div class="modal fade" id="ModalEdicion" tabindex="-1" aria-labelledby="ModalEdicionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalEdicionLabel">Editar Tipo de Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idtipo">
        <div class="form-group">
          <label for="tipousuario">Tipo de Usuario</label>
          <input type="text" id="tipousuario" class="form-control">
        </div>
        <div class="form-group mt-2">
          <label for="estadotipousuario">Estado</label>
          <select id="estadotipousuario" class="form-control">
            <option value="A">Activo</option>
            <option value="I">Inactivo</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="actualizatipousuario">Actualizar</button>
      </div>
    </div>
  </div>
</div>

<script>
    function agregaform(datos) {
        var d = datos.split('||');
        $('#idtipo').val(d[0]);
        $('#tipousuario').val(d[1]);
        $('#estadotipousuario').val(d[2]);
    }

    // Función para agregar tipo de usuario
    $('#guardartipousuario').click(function() {
        var tusuario = $('#tusuario').val();
        var estado = $('#estado').val();

        // Verifica que los campos no estén vacíos
        if (tusuario.trim() === "" || estado.trim() === "") {
            alertify.error("Todos los campos son obligatorios.");
            return;
        }

        // Realiza la petición AJAX para agregar el tipo de usuario
        $.ajax({
            type: "POST",
            url: "php/agregarDatos.php",
            data: { tusuario: tusuario, estado: estado },
            success: function(response) {
                if (response == 1) {
                    alertify.success("Agregado con éxito!");
                    $('#tabla').load('tabla.php');  // Recarga la tabla
                    $('#ModalNuevoTipo').modal('hide');  // Cierra el modal
                } else {
                    alertify.error("Error al agregar el tipo de usuario.");
                }
            },
            error: function() {
                alertify.error("Error de comunicación con el servidor.");
            }
        });
    });


    $('#actualizatipousuario').click(function(){
        var id = $('#idtipo').val();
        var tipo = $('#tipousuario').val();
        var estado = $('#estadotipousuario').val();

        if (tipo.trim() === "" || estado.trim() === "") {
            alertify.error("Todos los campos son obligatorios.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "php/actualizaDatos.php",
            data: { id: id, tipo: tipo, estado: estado },
            success: function(response) {
                if (response == 1) {
                    alertify.success("Actualizado con éxito!");
                    $('#tabla').load('tabla.php');
                    $('#ModalEdicion').modal('hide');
                } else {
                    alertify.error("Error al actualizar el tipo de usuario.");
                }
            },
            error: function() {
                alertify.error("Error de comunicación con el servidor.");
            }
        });
    });

    function preguntarSiNo(id) {
        alertify.confirm('Eliminar Tipo de Usuario', '¿Está seguro de eliminar este tipo de usuario?',
            function(){ eliminarDatos(id); },
            function(){ alertify.error('Cancelado'); });
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
                    $('#tabla').load('tabla.php');
                } else {
                    alertify.error("Error al eliminar el tipo de usuario.");
                }
            },
            error: function(xhr, status, error) {
                alertify.error("Error de comunicación con el servidor.");
            }
        });
    }
</script>
