<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Verificar si hay un mensaje de cierre de sesión exitoso
$logout_message = "";
if (isset($_SESSION['mensaje_logout'])) {
    $logout_message = $_SESSION['mensaje_logout'];
    unset($_SESSION['mensaje_logout']);
}

require_once 'php/conexion.php';
$conexion = conexion();

// Verificar si ya hay una sesión iniciada y redirigir al dashboard si es el administrador
if (isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario'] == 1) {
    header("Location: index.php");
    exit();
}

// Verificar si se está enviando un formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener los datos del usuario
    $sql = "
        SELECT u.id_usuario, u.nombre_usuario, u.email, u.password, u.id_tipo_usuario, tu.nombre_tipo, u.estado
        FROM usuarios u
        JOIN tipo_usuarios tu ON u.id_tipo_usuario = tu.id_tipo_usuario
        WHERE u.email = ?
    ";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el usuario existe
    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        
        // Verificar la contraseña con password_verify
        if (password_verify($password, $usuario['password'])) {
            // Verificar el estado del usuario
            if ($usuario['estado'] == 'I') {
                // Si el estado es "Inactivo" (I), redirigir a cambiar_contrasena.php
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['id_tipo_usuario'] = $usuario['id_tipo_usuario'];
                $_SESSION['nombre_tipo_usuario'] = $usuario['nombre_tipo'];
                header("Location: cambiar_contrasena.php");
                exit();
            } else {
                // Iniciar la sesión normalmente
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['id_tipo_usuario'] = $usuario['id_tipo_usuario'];
                $_SESSION['nombre_tipo_usuario'] = $usuario['nombre_tipo'];
                $_SESSION['mensaje_login_exitoso'] = "Inicio de sesión exitoso";
                
                // Redirigir al dashboard (index.php)
                header("Location: index.php");
                exit();
            }
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "El usuario no existe";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>

    <!-- Cargar jQuery primero -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Alertify JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

</head>
<body>
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card p-4" style="width: 300px;">
            <h3 class="text-center">Iniciar sesión</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalRegistro">Registrarse</button>
            </div>
        </div>
    </div>

    <!-- Modal de Cargando -->
    <div class="modal fade" id="ModalCargando" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p>Enviando correo y creando usuario...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="ModalRegistro" tabindex="-1" aria-labelledby="ModalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalRegistroLabel">Registro de Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formRegistro">
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" pattern=".+@heka\.com\.ec" required>
                        </div>
                        <button type="button" class="btn btn-warning w-100" onclick="registrarUsuario()">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Función para mostrar el modal de cargando
    function mostrarCargando() {
        // Cerrar el modal de registro antes de mostrar el de cargando
        $('#ModalRegistro').modal('hide');
        
        // Mostrar el modal de cargando
        var modal = new bootstrap.Modal(document.getElementById('ModalCargando'));
        modal.show();
    }

    // Función AJAX para registrar el usuario sin redireccionar
    function registrarUsuario() {
        // Llamamos a la función para cerrar el modal de registro y mostrar el modal de cargando
        mostrarCargando();

        var formData = {
            nombres: $("#nombres").val(),
            apellidos: $("#apellidos").val(),
            email: $("#email").val()
        };

        // Enviar los datos por AJAX
        $.ajax({
            url: 'php/procesar_registro.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Ocultar el modal de cargando
                $('#ModalCargando').modal('hide');

                if (response == 1) {
                    alertify.alert('Registro completado', 'Tu contraseña temporal se ha enviado al correo. Por favor, inicia sesión y cambia tu contraseña.', function(){
                        window.location.href = 'login.php';
                    });
                } else {
                    alertify.error('Error: ' + response);
                }
            },
            error: function() {
                // Ocultar el modal de cargando en caso de error
                $('#ModalCargando').modal('hide');
                alertify.error('Error al intentar registrar el usuario.');
            }
        });
    }
    </script>

    <!-- Mostrar mensajes con alertify -->
    <?php if (!empty($logout_message)): ?>
    <script>
        alertify.success("<?php echo $logout_message; ?>");
    </script>
    <?php endif; ?>

    <?php if (isset($error)): ?>
    <script>
        alertify.error('<?php echo $error; ?>');
    </script>
    <?php endif; ?>
</body>
</html>
