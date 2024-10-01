<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cotizador</title>
  <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">

  <script src="librerias/jquey/jquery.js"></script>
  <script src="librerias/bootstrap/js/funciones.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="librerias/alertifyjs/alertify.js"></script>

</head>
<body>
  <div class="container">
    <div class="table-container">
      <div id="tabla"></div>
    </div>
  </div>

  <!-- Modal Agregar -->
  <div class="modal fade" id="ModalNuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Nuevo tipo de usuario</h5>
        </div>
        <div class="modal-body">
          <label>Tipo de usuario</label>
          <input type="text" id="tusuario" class="form-control input-sm">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="guardartipousuario">Agregar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Editar -->
<div class="modal fade" id="ModalEdicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar tipo de usuario</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idpersona">
                <label>Actualizar usuario</label>
                <input type="text" id="usuariou" class="form-control input-sm">
                
                <!-- Añadir el campo de selección para el estado -->
                <label>Estado</label>
                <select id="estadou" class="form-control input-sm">
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


  <script type="text/javascript">
    $(document).ready(function(){
      $('#tabla').load('componentes/tabla.php');

      // Limpiar campos del modal de agregar al abrirlo
      $('#ModalNuevo').on('shown.bs.modal', function () {
        $('#tusuario').val('');  // Limpia el campo de texto
      });

      $('#guardartipousuario').click(function(){
        var tusuario = $('#tusuario').val();
        agregardatos(tusuario);
      });

      $('#actualizatipousuario').click(function(){
        actualizaDatos();
      });

      // Asegurarse de eliminar el backdrop cuando se cierra el modal manualmente
      $('#ModalNuevo, #ModalEdicion').on('hidden.bs.modal', function () {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
      });
    });

    function agregardatos(tusuario) {
    // Validar que el campo no esté vacío
    if (tusuario.trim() === "") {
        alertify.error("El campo Tipo de Usuario no puede estar vacío.");
        return;  // Detener el proceso si está vacío
    }

    var cadena = "tusuario=" + tusuario;

    $.ajax({
        type: "POST",
        url: "php/agregarDatos.php",
        data: cadena,
        success: function(r) {
            if (r == 1) {
                alertify.success("Agregado con éxito :)");
                $('#tabla').load('componentes/tabla.php');
                $('#ModalNuevo').modal('hide');  // Cierra el modal
                $('.modal-backdrop').remove();  // Elimina el backdrop
                $('body').removeClass('modal-open');  // Remueve la clase modal-open del body
                $('body').css('padding-right', '');  // Restablece el padding
            } else {
                alertify.error("Error del servidor: " + r);
            }
        },
        error: function(xhr, status, error) {
            alertify.error("Fallo en la comunicación con el servidor: " + error);
        }
    });
}


    function agregaform(datos){
    // Asegúrate de que estás capturando los 3 valores: id, usuario y estado
    d = datos.split('||');
    
    if (d[0] && d[1] && d[2]) {  // Asegúrate de que hay valores antes de asignarlos
        $('#idpersona').val(d[0]);
        $('#usuariou').val(d[1]);
        $('#estadou').val(d[2]);  // Captura el estado (A o I)
    } else {
        console.error("Datos incompletos para editar:", datos);
    }
}

    function actualizaDatos() {
    var id = $('#idpersona').val();
    var usuario = $('#usuariou').val();
    var estado = $('#estadou').val();  // Asegúrate de que el estado se captura correctamente

    // Validar antes de proceder
    if (!id || !usuario || !estado) {
        console.error("ID, usuario o estado no están definidos:", id, usuario, estado);
        alertify.error("ID, nombre de usuario o estado no válidos.");
        return;  // Sal del proceso si los valores no son válidos
    }

    var cadena = "id=" + id + "&tusuario=" + usuario + "&estado=" + estado;

    $.ajax({
        type: "POST",
        url: "php/actualizaDatos.php",
        data: cadena,
        success: function(r) {
            if (r == 1) {
                alertify.success("Actualizado con éxito :)");
                $('#tabla').load('componentes/tabla.php');
                $('#ModalEdicion').modal('hide');  // Cierra el modal
            } else {
                alertify.error("Error del servidor: " + r);
            }
        },
        error: function(xhr, status, error) {
            alertify.error("Fallo en la comunicación con el servidor: " + error);
        }
    });
}

    function preguntarSiNo(id){
      alertify.confirm('¿Está seguro de eliminar este registro?', 
        function(){ eliminarDatos(id) }, 
        function(){ alertify.error('Cancelado') });
    }

    function eliminarDatos(id){
      var cadena = "id=" + id;

      $.ajax({
        type: "POST",
        url: "php/eliminarDatos.php",
        data: cadena,
        success: function(r) {
          if (r == 1) {
            $('#tabla').load('componentes/tabla.php');
            alertify.success("Eliminado con éxito!");
          } else {
            alertify.error("Falló el servidor :(");
          }
        },
        error: function(xhr, status, error) {
          alertify.error("Fallo en la comunicación con el servidor: " + error);
        }
      });
    }
  </script>

</body>
</html>

<style>
  /* Eliminar el scroll doble */
  html, body {
    overflow: hidden;
  }

  .table-container {
    max-height: 800px; /* Ajusta este valor según la altura que necesites */
    overflow-y: auto;
  }
</style>



