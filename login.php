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

// Si ya hay una sesión iniciada, redirigir al dashboard
if (isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario'] == 136) {
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar la consulta para seleccionar el usuario
    $sql = "SELECT id_usuario, nombre_usuario, email, password, id_tipo_usuario FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el usuario existe
    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Verificar la contraseña usando password_verify
        if (password_verify($password, $usuario['password'])) {
            // Iniciar la sesión y guardar los datos del usuario
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['id_tipo_usuario'] = $usuario['id_tipo_usuario'];

            // Establecer una variable de sesión para el mensaje de éxito
            $_SESSION['mensaje_login_exitoso'] = "Inicio de sesión exitoso";

            // Redirigir al dashboard del administrador si es admin
            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }

    } else {
        // El usuario no existe
        $error = "El usuario no existe";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" href="librerias/alertifyjs/css/themes/default.css">
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
        </div>
    </div>

    <!-- Script de alertify.js -->
    <script src="librerias/alertifyjs/alertify.js"></script>

    <!-- Mostrar mensaje de cierre de sesión exitoso -->
    <?php if (!empty($logout_message)): ?>
    <script>
        alertify.success("<?php echo $logout_message; ?>");
    </script>
    <?php endif; ?>

    <!-- Mostrar errores con alertify -->
    <?php if (isset($error)): ?>
    <script>
        alertify.error('<?php echo $error; ?>');
    </script>
    <?php endif; ?>
</body>
</html>
