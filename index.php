<?php 
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

if (!isset($_SESSION['id_tipo_usuario']) || $_SESSION['id_tipo_usuario'] != 1) {
    header("Location: login.php");
    exit();
}

$mensaje_login = "";
if (isset($_SESSION['mensaje_login_exitoso'])) {
    $mensaje_login = $_SESSION['mensaje_login_exitoso'];
    unset($_SESSION['mensaje_login_exitoso']);
}

$mensaje_logout = "";
if (isset($_SESSION['mensaje_logout'])) {
    $mensaje_logout = $_SESSION['mensaje_logout'];
    unset($_SESSION['mensaje_logout']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 2rem;
        }
        .dashboard-header {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard-header h2 {
            font-size: 2.5rem;
            font-weight: 600;
        }
        .dashboard-header p {
            font-size: 1.25rem;
            color: #6c757d;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand">Administrador</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#" onclick="mostrarListaUsuarios()">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" onclick="mostrarTiposUsuarios()">Tipos de Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" onclick="mostrarCotizador()">Cotizador</a></li>
                </ul>
                <a href="#" class="btn btn-danger" id="cerrarSesionBtn">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div id="mainContent" class="dashboard-header">
            <h2>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?>!</h2>
            <p>Este es el panel de administración.</p>
        </div>
    </div>

    <!-- Mostrar alertify si hay mensaje de inicio de sesión -->
    <?php if (!empty($mensaje_login)): ?>
    <script>alertify.success("<?php echo $mensaje_login; ?>");</script>
    <?php endif; ?>

    <script>
        function mostrarListaUsuarios() {
            $('#mainContent').load('ver_usuarios.php');
        }

        function mostrarTiposUsuarios() {
            $('#mainContent').load('tabla.php');
        }

        function mostrarCotizador() {
            $('#mainContent').load('cotizador.php');
        }

        document.getElementById('cerrarSesionBtn').addEventListener('click', function(e) {
            e.preventDefault();
            alertify.confirm('Confirmar Cierre de Sesión', '¿Está seguro de que desea cerrar sesión?',
                function() { window.location.href = 'logout.php'; },
                function() { alertify.error('Cancelado'); }
            );
        });
    </script>
</body>
</html>
