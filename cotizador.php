<?php 
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

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

    <!-- Sección de Cotizador -->
    <div id="cotizador" class="container mt-5">
        <h2>Cotizador</h2>
        <!-- Checkbox principal -->
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkboxPrincipal">
            <label class="form-check-label" for="checkboxPrincipal">
                Seleccionar Opciones
            </label>
        </div>

        <!-- Checkboxes secundarios (inicialmente ocultos) -->
        <div id="checkboxSecundarios" class="mt-3" style="display:none;">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="opcion1">
                <label class="form-check-label" for="opcion1">Opción 1</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="opcion2">
                <label class="form-check-label" for="opcion2">Opción 2</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="opcion3">
                <label class="form-check-label" for="opcion3">Opción 3</label>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary" onclick="cotizar()">Generar Cotización</button>
        </div>

        <!-- Resultado de la cotización -->
        <div id="resultadoCotizacion" class="mt-4"></div>
    </div>

    <!-- Scripts para funcionalidad -->
    <script>
        // Mostrar/Ocultar los checkboxes secundarios cuando se marca/desmarca el checkbox principal
        $('#checkboxPrincipal').change(function() {
            if (this.checked) {
                $('#checkboxSecundarios').slideDown();
            } else {
                $('#checkboxSecundarios').slideUp();
            }
        });

        // Función para generar la cotización
        function cotizar() {
            let opcionesSeleccionadas = [];
            
            // Verificar qué opciones secundarias están seleccionadas
            $('#checkboxSecundarios input[type="checkbox"]').each(function() {
                if (this.checked) {
                    opcionesSeleccionadas.push($(this).next('label').text());
                }
            });

            // Mostrar las opciones seleccionadas
            if (opcionesSeleccionadas.length > 0) {
                $('#resultadoCotizacion').html(`<p>Has seleccionado: ${opcionesSeleccionadas.join(', ')}</p>`);
            } else {
                $('#resultadoCotizacion').html('<p>No has seleccionado ninguna opción.</p>');
            }
        }

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
