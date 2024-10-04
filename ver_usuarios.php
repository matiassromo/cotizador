<?php
require_once 'php/conexion.php';
$conexion = conexion();

// Consulta para obtener los usuarios de la base de datos
$sql = "SELECT nombre_usuario, email FROM usuarios";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="table">';
    echo '<thead><tr><th>Nombre de Usuario</th><th>Correo Electrónico</th></tr></thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['nombre_usuario'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo 'No se encontraron usuarios.';
}

$conexion->close();
?>
