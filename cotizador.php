<?php 
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
</head>
<body>
    <!-- Sección de Cotizador -->
    <div id="cotizador" class="container mt-5">
        <h2>Cotizador</h2>
        
        <!-- Checkbox principal -->
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkboxPrincipal">
            <label class="form-check-label" for="checkboxPrincipal">
                Seleccionar Dominios Específicos
            </label>
        </div>

        <!-- Checkboxes secundarios (inicialmente ocultos) con precios -->
        <div id="checkboxSecundarios" class="mt-3" style="display:none;">
            <!-- Dominios específicos con campos para precios -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gobierno_privacidad">
                <label class="form-check-label" for="gobierno_privacidad">Gobierno de la Privacidad</label>
                <input type="number" class="form-control mt-1" id="precio_gobierno_privacidad" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="privacidad_diseno">
                <label class="form-check-label" for="privacidad_diseno">Privacidad desde el Diseño y por Defecto</label>
                <input type="number" class="form-control mt-1" id="precio_privacidad_diseno" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="accountability">
                <label class="form-check-label" for="accountability">Accountability</label>
                <input type="number" class="form-control mt-1" id="precio_accountability" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="registro_actividades">
                <label class="form-check-label" for="registro_actividades">Registro de Actividades de Tratamiento</label>
                <input type="number" class="form-control mt-1" id="precio_registro_actividades" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="legitimacion">
                <label class="form-check-label" for="legitimacion">Legitimación, Información y Consentimiento</label>
                <input type="number" class="form-control mt-1" id="precio_legitimacion" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="encargos_tratamiento">
                <label class="form-check-label" for="encargos_tratamiento">Encargos de Tratamiento</label>
                <input type="number" class="form-control mt-1" id="precio_encargos_tratamiento" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="transferencias_internacionales">
                <label class="form-check-label" for="transferencias_internacionales">Transferencias Internacionales de Datos</label>
                <input type="number" class="form-control mt-1" id="precio_transferencias_internacionales" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="derechos_interesados">
                <label class="form-check-label" for="derechos_interesados">Derechos de los Interesados</label>
                <input type="number" class="form-control mt-1" id="precio_derechos_interesados" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="medidas_seguridad">
                <label class="form-check-label" for="medidas_seguridad">Medidas de Seguridad</label>
                <input type="number" class="form-control mt-1" id="precio_medidas_seguridad" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="violaciones_seguridad">
                <label class="form-check-label" for="violaciones_seguridad">Violaciones de Seguridad de Datos Personales</label>
                <input type="number" class="form-control mt-1" id="precio_violaciones_seguridad" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="analisis_riesgos">
                <label class="form-check-label" for="analisis_riesgos">Análisis de Riesgos y EIPD</label>
                <input type="number" class="form-control mt-1" id="precio_analisis_riesgos" placeholder="Precio" style="display:none;">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="lopd_especificos">
                <label class="form-check-label" for="lopd_especificos">LOPDP (Específicos) Tratamiento de Categoría Especial</label>
                <input type="number" class="form-control mt-1" id="precio_lopd_especificos" placeholder="Precio" style="display:none;">
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-primary" onclick="cotizar()">Generar Cotización</button>
        </div>

        <!-- Resultado de la cotización -->
        <div id="resultadoCotizacion" class="mt-4"></div>
    </div>

    <!-- Scripts para funcionalidad -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        // Mostrar/Ocultar los checkboxes secundarios cuando se marca/desmarca el checkbox principal
        $('#checkboxPrincipal').change(function() {
            if (this.checked) {
                $('#checkboxSecundarios').slideDown();
            } else {
                $('#checkboxSecundarios').slideUp();
            }
        });

        // Mostrar/ocultar el campo de precio cuando se selecciona/deselecciona una opción
        $('#checkboxSecundarios input[type="checkbox"]').change(function() {
            let precioInput = $(this).nextAll('input[type="number"]');
            if (this.checked) {
                precioInput.show();
            } else {
                precioInput.hide();
                precioInput.val('');  // Limpiar el campo de precio si se deselecciona
            }
        });

        // Función para generar la cotización
        function cotizar() {
            let opcionesSeleccionadas = [];
            let total = 0;

            // Verificar qué opciones secundarias están seleccionadas
            $('#checkboxSecundarios input[type="checkbox"]').each(function() {
                if (this.checked) {
                    let opcion = $(this).next('label').text();
                    let precio = parseFloat($(this).nextAll('input[type="number"]').val()) || 0;
                    opcionesSeleccionadas.push(`${opcion} - $${precio.toFixed(2)}`);
                    total += precio;
                }
            });

            // Mostrar el resultado de la cotización
            if (opcionesSeleccionadas.length > 0) {
                $('#resultadoCotizacion').html(`
                    <p>Has seleccionado: ${opcionesSeleccionadas.join(', ')}</p>
                    <p>Total: $${total.toFixed(2)}</p>
                `);
            } else {
                $('#resultadoCotizacion').html('<p>No has seleccionado ninguna opción.</p>');
            }
        }
    </script>
</body>
</html>
