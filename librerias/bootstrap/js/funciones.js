function agregardatos(tusuario) {
    cadena = "tusuario=" + tusuario;

    $.ajax({
        type: "POST",
        url: "php/agregarDatos.php",
        data: cadena,
        success: function(r) {
            if (r == 1) {
                alertify.success("Agregado con éxito :)");
                $('#tabla').load('componentes/tabla.php');
                $('#ModalNuevo').modal('hide');  // Cierra el modal
                
                // Elimina manualmente el backdrop para evitar el fondo gris
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open'); // Remueve la clase modal-open del body
                $('body').css('padding-right', ''); // Restablece cualquier padding añadido al body
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

	d= datos.split('||');
	$('#idpersona').val(d[0]);
	$('#usuariou').val(d[1]);

	cadena = "id=" + id + 
		     "tusuario=" + tusuario;
}

function actualizaDatos(){
	id = $('#idpersona').val();
	usuario = $('#usuariou').val();


	$.ajax({
        type: "POST",
        url: "php/actualizaDatos.php",
        data: cadena,
        success: function(r) {
            if (r == 1) {
                alertify.success("Actualizado con éxito :)");
                $('#tabla').load('componentes/tabla.php');
                $('#ModalNuevo').modal('hide');  // Cierra el modal
                
                // Elimina manualmente el backdrop para evitar el fondo gris
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open'); // Remueve la clase modal-open del body
                $('body').css('padding-right', ''); // Restablece cualquier padding añadido al body
            } else {
                alertify.error("Error del servidor: " + r);
            }
        },
        error: function(xhr, status, error) {
            alertify.error("Fallo en la comunicación con el servidor: " + error);
        }
    });
}
