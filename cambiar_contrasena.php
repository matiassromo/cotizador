<?php
session_start();
require_once 'php/conexion.php';
$conexion = conexion();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    $id_usuario = $_SESSION['id_usuario'];

    // Verificar que las contraseñas coincidan
    if ($nueva_contrasena !== $confirmar_contrasena) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($nueva_contrasena) < 8) {  // Validar que la nueva contraseña tenga al menos 8 caracteres
        $error = "La nueva contraseña debe tener al menos 8 caracteres.";
    } else {
        // Encriptar la nueva contraseña
        $password_hash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

        // Actualizar la contraseña en la base de datos y cambiar el estado a 'Activo'
        $sql = "UPDATE usuarios SET password = ?, estado = 'A' WHERE id_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("si", $password_hash, $id_usuario);

        if ($stmt->execute()) {
            // Contraseña actualizada exitosamente
            $_SESSION['mensaje_cambio_contrasena'] = "Contraseña cambiada exitosamente. Por favor, inicia sesión.";
            // Destruir la sesión actual para forzar al usuario a iniciar sesión de nuevo
            session_destroy();
            header("Location: login.php");  // Redirigir al login
            exit();
        } else {
            $error = "Error al actualizar la contraseña. Inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" href="librerias/alertifyjs/css/themes/default.css">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card p-4" style="width: 300px;">
            <form id="formCambioContrasena" method="POST" action="">
                <div class="form-group">
                    <label for="nueva_contrasena">Nueva Contraseña:</label>
                    <input type="password" id="nueva_contrasena" name="nueva_contrasena" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                    <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" class="form-control" required>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary btn-block">Cambiar Contraseña</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mostrar errores -->
    <?php if (isset($error)): ?>
    <script>
        alertify.error('<?php echo $error; ?>');
    </script>
    <?php endif; ?>

    <!-- Mostrar mensaje de éxito -->
    <?php if (isset($_SESSION['mensaje_cambio_contrasena'])): ?>
    <script>
        alertify.success("<?php echo $_SESSION['mensaje_cambio_contrasena']; ?>");
        <?php unset($_SESSION['mensaje_cambio_contrasena']); ?>
    </script>
    <?php endif; ?>

    <!-- Incluir scripts de jQuery, Bootstrap y alertify.js -->
    <script src="librerias/jquery/jquery-3.6.0.min.js"></script>
    <script src="librerias/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="librerias/alertifyjs/alertify.js"></script>

    <!-- Validación en el frontend -->
    <script>
        document.getElementById('formCambioContrasena').addEventListener('submit', function(event) {
            const nuevaContrasena = document.getElementById('nueva_contrasena').value;
            const confirmarContrasena = document.getElementById('confirmar_contrasena').value;

            // Validar si las contraseñas coinciden
            if (nuevaContrasena !== confirmarContrasena) {
                event.preventDefault();  // Detener el envío del formulario
                alertify.error('Las contraseñas no coinciden.');
            } else if (nuevaContrasena.length < 8) {
                event.preventDefault();  // Detener el envío del formulario
                alertify.error('La nueva contraseña debe tener al menos 8 caracteres.');
            }
        });
    </script>
</body>
</html>
