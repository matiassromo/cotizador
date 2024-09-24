function agregardatos(tusuario) {
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
    d = datos.split('||');
    
    if (d[0] && d[1]) {  // Asegúrate de que hay valores antes de asignarlos
        $('#idpersona').val(d[0]);
        $('#usuariou').val(d[1]);
    } else {
        console.error("Datos incompletos para editar:", datos);
    }
}



function actualizaDatos() {
    var id = $('#idpersona').val();
    var usuario = $('#usuariou').val();

    // Validar antes de proceder
    if (!id || !usuario) {
        console.error("ID o usuario no están definidos:", id, usuario);
        alertify.error("ID o nombre de usuario no válidos.");
        return;  // Sal del proceso si los valores no son válidos
    }

    var cadena = "id=" + id + "&tusuario=" + usuario;

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



function preguntarSiNo(id) {
    alertify.confirm('¿Está seguro de eliminar este registro?', 
        function(){ eliminarDatos(id) }, 
        function(){ alertify.error('Cancelado') });
}

function eliminarDatos(id) {
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
