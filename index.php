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
		<div id="tabla"></div>
	</div>

<!-- Botón Nueva Empresa -->
<div class="modal fade" id="ModalNuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo tipo de usuario</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>-->
        </button>
      </div>
      <div class="modal-body">
      	<label>Tipo de usuario</label>
      	<input type="text" id="tusuario" class="form-control input-sm">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="guardartipousuario">
        Agregar
    </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>

<!-- Botón Edición -->
<div class="modal fade" id="ModalEdicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <!--<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>-->
        </button>
      </div>
      <div class="modal-body">
      	<input type="text" hidden="" id="idpersona" name="">
      	<label>Actualizar usuario</label>
      	<input type="text" id="usuariou" class="form-control input-sm">
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-warning" data-bs-dismiss id="actualizatipousuario">Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){
    $('#tabla').load('componentes/tabla.php');
});

</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#guardartipousuario').click(function(){
        tusuario =$ ('#tusuario').val();
        agregardatos(tusuario);
    });

    $('#actualizatipousuario').click(function(){
      actualizaDatos();
    });


  });
</script>